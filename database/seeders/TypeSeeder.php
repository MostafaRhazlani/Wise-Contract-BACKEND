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
        $types = [
            [
                'title' => 'Contract A4',
                'logo' => 'ReceiptText',
                'color' => '#4F8A8B',
                'width' => 794,   // A4 width in px at 96 DPI
                'height' => 1122  // A4 height in px at 96 DPI
            ],
            [
                'title' => 'Invoice A4',
                'logo' => 'FileText',
                'color' => '#2563EB',
                'width' => 794,   // A4 width in px at 96 DPI
                'height' => 1122  // A4 height in px at 96 DPI
            ]
            
        ];

        foreach ($types as $type) {
            Type::create($type);
        }
    }
}
