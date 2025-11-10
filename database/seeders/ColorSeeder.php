<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Color;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            [
                'name' => 'Burgundy',
                'value' => 'burgundy',
                'image' => 'Burgundy.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Blue',
                'value' => 'blue',
                'image' => 'Blue.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Green',
                'value' => 'green',
                'image' => 'green.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Tan',
                'value' => 'tan',
                'image' => 'tan.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Grey',
                'value' => 'grey',
                'image' => 'grey.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Purple',
                'value' => 'purple',
                'image' => 'purple.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Orange',
                'value' => 'orange',
                'image' => 'orange.jpg',
                'is_active' => true,
            ],
        ];

        foreach ($colors as $color) {
            Color::create($color);
        }
    }
}
