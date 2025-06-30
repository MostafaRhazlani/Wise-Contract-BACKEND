<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['Contract', 'CV'];
        $icons = ['ReceiptText', 'FileUser'];
        $colors = ['#4F8A8B', '#F9A826'];

        foreach ($types as $key => $type) {
            Type::create([
                'title' => $type,
                'logo' => $icons[$key],
                'color' => $colors[$key]
            ]);
        }
    }
}
