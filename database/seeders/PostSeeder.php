<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Department;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create additional random posts
        Post::factory(10)->create();
    }
}