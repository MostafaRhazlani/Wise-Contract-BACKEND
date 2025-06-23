<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CompanyController extends Controller
{
    /**
     * Get company structure with departments, posts, and employees (users)
     */
    public function getCompanyStructure(Company $company): JsonResponse
    {
        $companyData = $company->load([
            'departments.posts.users' => function ($query) {
                $query->whereHas('role', function ($roleQuery) {
                    $roleQuery->where('role_name', 'employee');
                });
            }
        ]);

        $response = [
            'companyName' => $companyData->company_name,
            'companyLogo' => $companyData->company_logo ?? 'https://placehold.co/400x200/006400/FFFFFF?text=COMPANY+LOGO',
            'departments' => $companyData->departments->map(function ($department) {
                return [
                    'id' => $department->id,
                    'name' => $department->department_name,
                    'posts' => $department->posts->map(function ($post) {
                        return [
                            'id' => $post->id,
                            'title' => $post->title,
                            'users' => $post->users->map(function ($user) {
                                $nameParts = explode(' ', $user->name);
                                return [
                                    'id' => $user->id,
                                    'firstName' => $nameParts[0] ?? '',
                                    'lastName' => $nameParts[1] ?? '',
                                    'email' => $user->email,
                                    'joinDate' => $user->join_date ? $user->join_date->format('Y-m-d') : null,
                                    'dateTime' => $user->created_at->toISOString(),
                                ];
                            })
                        ];
                    })
                ];
            })
        ];

        return response()->json($response);
    }

    /**
     * Get all companies
     */
    public function index(): JsonResponse
    {
        $companies = Company::all();
        
        return response()->json([
            'success' => true,
            'data' => $companies
        ]);
    }
}