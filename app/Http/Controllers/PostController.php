<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $posts = Post::with(['department'])
            ->withCount('users') // Add count of users for each post
            ->get()
            ->map(function ($post) {
                return [
                    'id' => $post->id,
                    'title' => $post->title,
                    'department_name' => $post->department->department_name ?? 'N/A',
                    'department_id' => $post->department_id,
                    'employees_count' => $post->users_count,
                    'created_at' => $post->created_at,
                    'updated_at' => $post->updated_at,
                ];
            });
        
        return response()->json([
            'posts' => $posts
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
                'title' => 'required|string|max:255',
                'department_id' => 'required|exists:departments,id'
            ]);

            $post = Post::create([
                'title' => $request->title,
                'department_id' => $request->department_id
            ]);

            $post->load(['department']);

            return response()->json([
                'success' => true,
                'message' => 'Post created successfully.',
                'post' => [
                    'id' => $post->id,
                    'title' => $post->title,
                    'department_name' => $post->department->department_name ?? 'N/A',
                    'department_id' => $post->department_id,
                    'employees_count' => 0, // New post has no employees
                    'created_at' => $post->created_at,
                    'updated_at' => $post->updated_at,
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
    public function show(Post $post): JsonResponse
    {
        $post->load(['department']);
        $post->loadCount('users');

        return response()->json([
            'success' => true,
            'post' => [
                'id' => $post->id,
                'title' => $post->title,
                'department_name' => $post->department->department_name ?? 'N/A',
                'department_id' => $post->department_id,
                'employees_count' => $post->users_count,
                'employees' => $post->users()->with(['role'])->get()->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $user->role->role_name ?? 'N/A',
                    ];
                }),
                'created_at' => $post->created_at,
                'updated_at' => $post->updated_at,
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post): JsonResponse
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
                'title' => 'required|string|max:255',
                'department_id' => 'required|exists:departments,id'
            ]);

            $post->update([
                'title' => $request->title,
                'department_id' => $request->department_id
            ]);

            $post->load(['department']);
            $post->loadCount('users');

            return response()->json([
                'success' => true,
                'message' => 'Post updated successfully.',
                'post' => [
                    'id' => $post->id,
                    'title' => $post->title,
                    'department_name' => $post->department->department_name ?? 'N/A',
                    'department_id' => $post->department_id,
                    'employees_count' => $post->users_count,
                    'created_at' => $post->created_at,
                    'updated_at' => $post->updated_at,
                ]
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
    public function destroy(Post $post): JsonResponse
    {
        // Check if user is admin
        if (!$this->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Admin access required.'
            ], 403);
        }

        // Check if post has users
        if ($post->users()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete post. It has associated users.'
            ], 400);
        }

        $postTitle = $post->title;
        $post->delete();

        return response()->json([
            'success' => true,
            'message' => "Post '{$postTitle}' deleted successfully."
        ]);
    }

    /**
     * Get posts by department
     */
    public function getPostsByDepartment(Request $request, $departmentId): JsonResponse
    {
        $department = Department::findOrFail($departmentId);
        
        $posts = Post::where('department_id', $departmentId)
            ->withCount('users')
            ->get()
            ->map(function ($post) use ($department) {
                return [
                    'id' => $post->id,
                    'title' => $post->title,
                    'department_name' => $department->department_name,
                    'department_id' => $post->department_id,
                    'employees_count' => $post->users_count,
                    'created_at' => $post->created_at,
                    'updated_at' => $post->updated_at,
                ];
            });

        return response()->json([
            'success' => true,
            'department' => $department->department_name,
            'posts' => $posts
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
