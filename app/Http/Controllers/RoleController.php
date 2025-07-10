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
}
