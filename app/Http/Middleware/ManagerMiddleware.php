<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ManagerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || $request->user()->role_id !== 3) { // Manager role_id is 3
            return response()->json(['message' => 'Unauthorized. Manager access required.'], 403);
        }

        return $next($request);
    }
}