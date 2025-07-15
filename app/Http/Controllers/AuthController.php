<?php
// filepath: app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        Log::info('Registration request received', $request->all());

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|same:password',
            'phone' => 'required|string|max:20',
            'role_id' => 'required|integer|exists:roles,id',
            'company_name' => 'required|string|max:255',
            'company_email' => 'required|string|email|max:255|unique:companies,email',
            'company_address' => 'required|string|max:500',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed', [
                'errors' => $validator->errors()->toArray(),
                'request_data' => $request->except(['password', 'password_confirmation'])
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if the role exists
        $role = Role::find($request->role_id);
        if (!$role) {
            Log::error('Role not found', ['role_id' => $request->role_id]);
            return response()->json([
                'success' => false,
                'message' => 'Selected role does not exist',
                'errors' => ['role_id' => ['Selected role is invalid']]
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Handle file upload
            $logoPath = null;
            if ($request->hasFile('company_logo')) {
                $logoFile = $request->file('company_logo');
                $logoPath = $logoFile->store('company_logos', 'public');
                Log::info('Logo uploaded successfully', ['path' => $logoPath]);
            }

            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'role_id' => $request->role_id,
                'email_verified_at' => now(),
            ]);

            Log::info('User created successfully', ['user_id' => $user->id]);

            // Create company
            $company = Company::create([
                'company_name' => $request->company_name,
                'email' => $request->company_email,
                'address' => $request->company_address,
                'company_logo' => $logoPath, // Store file path instead of base64
                'owner_id' => $user->id,
            ]);

            Log::info('Company created successfully', ['company_id' => $company->id]);

            // Update user with company_id
            $user->update(['company_id' => $company->id]);
            
            // Load relationships
            $user->load(['company', 'role']);

            $token = $user->createToken('auth_token')->plainTextToken;

            DB::commit();

            Log::info('Registration completed successfully', [
                'user_id' => $user->id,
                'company_id' => $company->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Registration successful',
                'token' => $token,
                'user' => $user,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Delete uploaded file if registration fails
            if ($logoPath && Storage::disk('public')->exists($logoPath)) {
                Storage::disk('public')->delete($logoPath);
            }
            
            Log::error('Registration failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->except(['password', 'password_confirmation'])
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Registration failed: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user->load(['company', 'role', 'department', 'post']),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ]);
    }

    public function checkAuthenticatedUser(Request $request)
    {
        return response()->json([
            'success' => true,
            'user' => $request->user()->load(['company', 'role', 'department', 'post'])
        ]);
    }
}