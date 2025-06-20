<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VariableController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'checkAuthenticatedUser']);

    // Department routes
    Route::get('/departments', [DepartmentController::class, 'index']);
    Route::get('/departments/{department}', [DepartmentController::class, 'show']);
    Route::post('/departments', [DepartmentController::class, 'store']);
    Route::put('/departments/{department}', [DepartmentController::class, 'update']);
    Route::delete('/departments/{department}', [DepartmentController::class, 'destroy']);

    // Variables routes - only developers can create/update/delete
    Route::get('/variables', [VariableController::class, 'index']);
    Route::get('/variables/{variable}', [VariableController::class, 'show']);
    Route::post('/variables', [VariableController::class, 'store']);
    Route::put('/variables/{variable}', [VariableController::class, 'update']);
    Route::delete('/variables/{variable}', [VariableController::class, 'destroy']);

    // User routes
    Route::get('/users', [UserController::class, 'index']);
});
