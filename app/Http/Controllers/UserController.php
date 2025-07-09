<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $authUser = $request->user();
        if (!$authUser || !$authUser->company_id) {
            return response()->json(['users' => []]);
        }

        $users = User::where('company_id', $authUser->company_id)
            ->whereIn('role_id', [2, 4]) // Only Employee and Editor roles
            ->with(['department', 'post', 'role'])
            ->get();

        return response()->json(['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|unique:users',
            'role_id' => 'required|exists:roles,id',
            'password' => 'required_if:role_id,4|nullable|string|min:8', // Required only for Editor (role_id 4)
            'department_id' => 'required|exists:departments,id',
            'post_id' => 'required|exists:posts,id',
            'join_date' => 'nullable|date',
        ]);

        $manager = $request->user();
        
        // Generate a random password for employees (role_id 2) if no password provided
        $password = null;
        if ($request->role_id == 4) { // Editor
            $password = bcrypt($request->password);
        } elseif ($request->role_id == 2) { // Employee
            $password = bcrypt(Str::random(16)); // Generate random password they won't use
        }
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $password,
            'company_id' => $manager->company_id,
            'role_id' => $request->role_id,
            'department_id' => $request->department_id,
            'post_id' => $request->post_id,
            'join_date' => $request->join_date ?? now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User added successfully',
            'user' => $user->load(['department', 'post', 'role'])
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $manager = $request->user();
        
        // Ensure the user being updated belongs to the same company
        if ($user->company_id !== $manager->company_id) {
            return response()->json([
                'success' => false,
                'message' => 'You can only update users from your company'
            ], 403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|unique:users,phone,' . $user->id,
            'role_id' => 'required|exists:roles,id',
            'password' => 'nullable|string|min:8',
            'department_id' => 'required|exists:departments,id',
            'post_id' => 'required|exists:posts,id',
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role_id' => $request->role_id,
            'department_id' => $request->department_id,
            'post_id' => $request->post_id,
        ];

        // Update password only if provided
        if ($request->password) {
            $updateData['password'] = bcrypt($request->password);
        }

        $user->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
            'user' => $user->load(['department', 'post', 'role'])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $manager = request()->user();
        
        // Ensure the user being deleted belongs to the same company
        if ($user->company_id !== $manager->company_id) {
            return response()->json([
                'success' => false,
                'message' => 'You can only delete users from your company'
            ], 403);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully'
        ]);
    }
}
