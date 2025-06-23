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
    public function show(Request $request): JsonResponse
    {
        $auth_user = $request->user();
        $company = null;
        if($auth_user) {
            if($auth_user->company) {
                $company = $auth_user->company;
            } else if($auth_user->ownedCompany) {
                $company = $auth_user->ownedCompany;
            }
        }

        return response()->json([
            'success' => true,
            'company' => $company
        ]);
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

    /**
     * Get the company info if the user works at it or is the owner
     */
    public function myCompany(Request $request): JsonResponse
    {
        $user = $request->user();
        $company = null;
        if ($user) {
            // Check if user is an employee
            if ($user->company) {
                $company = $user->company;
            }
            // Check if user is an owner
            elseif ($user->ownedCompanies) {
                $company = $user->ownedCompanies;
            }
        }
        return response()->json([
            'success' => true,
            'data' => $company
        ]);
    }
}