<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $departments = Department::withCount(['posts', 'users'])
            ->get()
            ->map(function ($department) {
                return [
                    'id' => $department->id,
                    'department_name' => $department->department_name,
                    'posts_count' => $department->posts_count,
                    'employees_count' => $department->users_count,
                    'created_at' => $department->created_at,
                    'updated_at' => $department->updated_at,
                ];
            });
        
        return response()->json([
            'departments' => $departments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        // Check if user is admin
        if (!$this->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Admin access required.'
            ], 403);
        }

        try {
            $request->validate([
                'department_name' => 'required|string|max:255|unique:departments,department_name'
            ]);

            $department = Department::create([
                'department_name' => $request->department_name
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Department created successfully.',
                'department' => [
                    'id' => $department->id,
                    'department_name' => $department->department_name,
                    'posts_count' => 0,
                    'employees_count' => 0,
                    'created_at' => $department->created_at,
                    'updated_at' => $department->updated_at,
                ]
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department): JsonResponse
    {
        $department->loadCount(['posts', 'users']);

        return response()->json([
            'success' => true,
            'department' => [
                'id' => $department->id,
                'department_name' => $department->department_name,
                'posts_count' => $department->posts_count,
                'employees_count' => $department->users_count,
                'posts' => $department->posts()->withCount('users')->get()->map(function ($post) {
                    return [
                        'id' => $post->id,
                        'title' => $post->title,
                        'employees_count' => $post->users_count,
                    ];
                }),
                'created_at' => $department->created_at,
                'updated_at' => $department->updated_at,
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department): JsonResponse
    {
        // Check if user is admin
        if (!$this->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Admin access required.'
            ], 403);
        }

        try {
            $request->validate([
                'department_name' => 'required|string|max:255|unique:departments,department_name,' . $department->id
            ]);

            $department->update([
                'department_name' => $request->department_name
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Department updated successfully.',
                'department' => $department
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department): JsonResponse
    {
        // Check if user is admin
        if (!$this->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Admin access required.'
            ], 403);
        }

        // Check if department has users
        if ($department->users()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete department. It has associated users.'
            ], 400);
        }

        // Check if department has posts
        if ($department->posts()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete department. It has associated posts.'
            ], 400);
        }

        $department->delete();

        return response()->json([
            'success' => true,
            'message' => 'Department deleted successfully.'
        ]);
    }

    /**
     * Check if the authenticated user is an admin.
     */
    private function isAdmin(): bool
    {
        $user = auth()->user();
        return $user && $user->role && $user->role->role_name === 'Admin';
    }
}
