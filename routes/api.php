<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\VariableController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PostController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Public role route for registration
Route::get('/roles/public', [RoleController::class, 'publicRoles']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'checkAuthenticatedUser']);

    // User routes
    Route::get('/users', [UserController::class, 'index']);
    
    // Role routes
    Route::get('/roles', [RoleController::class, 'index']);
    
    // Department routes
    Route::get('/departments', [DepartmentController::class, 'index']);
    
    // Post routes
    Route::get('/posts', [PostController::class, 'index']);
    
    Route::middleware('manager')->group(function() {
        Route::post('/users', [UserController::class, 'store']);
        Route::put('/users/{user}', [UserController::class, 'update']);
        Route::delete('/users/{user}', [UserController::class, 'destroy']);
    });

    // Company routes
    Route::get('/company/show', [CompanyController::class, 'show']);

    // Template routes
    Route::post('/template/save', [TemplateController::class, 'store']);
    Route::get('/company/templates/{company_id}/{type_id}', [TemplateController::class, 'companyTemplatesWithType']);
    Route::get('/company/templates/{company_id}', [TemplateController::class, 'companyTemplates']);
    Route::get('/template/{id}', [TemplateController::class, 'show']);

    // Type routes
    Route::get('/types', [TypeController::class, 'index']);
});
