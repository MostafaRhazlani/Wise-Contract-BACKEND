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
                'title' => 'CV A4',
                'logo' => 'FileUser',
                'color' => '#F9A826',
                'width' => 794,   // A4 width in px at 96 DPI
                'height' => 1122  // A4 height in px at 96 DPI
            ],
            [
                'title' => 'Contract A5',
                'logo' => 'ReceiptText',
                'color' => '#8B5A2B',
                'width' => 559,   // A5 width in px at 96 DPI
                'height' => 794   // A5 height in px at 96 DPI
            ],
            [
                'title' => 'CV A5',
                'logo' => 'FileUser',
                'color' => '#2B8B4F',
                'width' => 559,   // A5 width in px at 96 DPI
                'height' => 794   // A5 height in px at 96 DPI
            ],
            [
                'title' => 'Contract A2',
                'logo' => 'ReceiptText',
                'color' => '#8B2B4F',
                'width' => 1587,  // A2 width in px at 96 DPI
                'height' => 2244  // A2 height in px at 96 DPI
            ],
            [
                'title' => 'CV A2',
                'logo' => 'FileUser',
                'color' => '#4F2B8B',
                'width' => 1587,  // A2 width in px at 96 DPI
                'height' => 2244  // A2 height in px at 96 DPI
            ]
        ];

        foreach ($types as $type) {
            Type::create($type);
        }
    }
}
