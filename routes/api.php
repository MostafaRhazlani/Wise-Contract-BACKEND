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

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'checkAuthenticatedUser']);

    // Department routes - only admin can create / update / delete
    Route::get('/departments', [DepartmentController::class, 'index']);
    Route::middleware('admin')->group(function() {
        Route::get('/departments/{department}', [DepartmentController::class, 'show']);
        Route::post('/departments', [DepartmentController::class, 'store']);
        Route::put('/departments/{department}', [DepartmentController::class, 'update']);
        Route::delete('/departments/{department}', [DepartmentController::class, 'destroy']);
    });

    // Variables routes
    Route::get('/variables', [VariableController::class, 'index']);
    Route::middleware('developer')->group(function() {
        Route::get('/variable/{variable}', [VariableController::class, 'show']);
        Route::post('/variable', [VariableController::class, 'store']);
        Route::put('/variable/{variable}', [VariableController::class, 'update']);
        Route::delete('/variable/{variable}', [VariableController::class, 'destroy']);
    });

    // User routes
    Route::get('/users', [UserController::class, 'index']);

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
