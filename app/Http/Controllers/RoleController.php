<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::whereIn('id', [2, 4])->get(); // Only Employee and Editor roles
        
        return response()->json([
            'roles' => $roles
        ]);
    }

    public function publicRoles()
    {
        // For registration, only show Manager role
        $roles = Role::whereIn('id', [3])->get(); // Only Manager role
        
        return response()->json([
            'roles' => $roles
        ]);
    }
}
