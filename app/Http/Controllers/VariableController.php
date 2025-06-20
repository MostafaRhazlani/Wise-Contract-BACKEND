<?php

namespace App\Http\Controllers;

use App\Models\Variable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class VariableController extends Controller
{
    /**
     * Display a listing of variables.
     */
    public function index(): JsonResponse
    {
        $variables = Variable::all();
        
        return response()->json([
            'success' => true,
            'data' => $variables
        ]);
    }

    /**
     * Store a newly created variable.
     */
    public function store(Request $request): JsonResponse
    {
        // Check if user is developer
        if (!$this->isDeveloper()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Developer access required.'
            ], 403);
        }

        try {
            $request->validate([
                'key' => 'required|string|max:255|unique:variables,key',
                'label' => 'required|string|max:255'
            ]);

            $variable = Variable::create([
                'key' => $request->key,
                'label' => $request->label
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Variable created successfully.',
                'data' => $variable
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
     * Display the specified variable.
     */
    public function show(Variable $variable): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $variable
        ]);
    }

    /**
     * Update the specified variable.
     */
    public function update(Request $request, Variable $variable): JsonResponse
    {
        // Check if user is developer
        if (!$this->isDeveloper()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Developer access required.'
            ], 403);
        }

        try {
            $request->validate([
                'key' => 'required|string|max:255|unique:variables,key,' . $variable->id,
                'label' => 'required|string|max:255'
            ]);

            $variable->update([
                'key' => $request->key,
                'label' => $request->label
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Variable updated successfully.',
                'data' => $variable
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
     * Remove the specified variable.
     */
    public function destroy(Variable $variable): JsonResponse
    {
        // Check if user is developer
        if (!$this->isDeveloper()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Developer access required.'
            ], 403);
        }

        $variable->delete();

        return response()->json([
            'success' => true,
            'message' => 'Variable deleted successfully.'
        ]);
    }

    /**
     * Check if the authenticated user is a developer.
     */
    private function isDeveloper(): bool
    {
        $user = auth()->user();
        return $user && $user->role && $user->role->role_name === 'Developer';
    }
}