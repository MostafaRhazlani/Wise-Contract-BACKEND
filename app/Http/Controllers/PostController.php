<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        // Since posts table doesn't have company_id, return all posts
        $posts = Post::all();
        
        return response()->json([
            'posts' => $posts
        ]);
    }
}
