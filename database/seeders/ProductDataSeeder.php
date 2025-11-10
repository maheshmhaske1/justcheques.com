<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\QuantityTier;
use App\Models\Pricing;
use Illuminate\Support\Str;

class ProductDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Step 1: Create Quantity Tiers
        $quantityTiers = [
            ['quantity' => 100, 'display_order' => 1],
            ['quantity' => 250, 'display_order' => 2],
            ['quantity' => 500, 'display_order' => 3],
            ['quantity' => 1000, 'display_order' => 4],
            ['quantity' => 1500, 'display_order' => 5],
            ['quantity' => 2000, 'display_order' => 6],
            ['quantity' => 2500, 'display_order' => 7],
        ];

        $tierIds = [];
        foreach ($quantityTiers as $tier) {
            $created = QuantityTier::firstOrCreate(
                ['quantity' => $tier['quantity']],
                ['display_order' => $tier['display_order'], 'is_active' => true]
            );
            $tierIds[$tier['quantity']] = $created->id;
        }

        // Step 2: Product Data
        $products = [
            [
                "category" => "Manual Cheques",
                "subcategory" => "1 up Manual Green",
                "image" => "green.jpg",
                "prices" => [100 => 59, 250 => 79, 500 => 99, 1000 => 129, 1500 => 179, 2000 => 229, 2500 => 299]
            ],
            [
                "category" => "Manual Cheques",
                "subcategory" => "1 up Manual Blue",
                "image" => "Blue.jpg",
                "prices" => [100 => 59, 250 => 79, 500 => 99, 1000 => 129, 1500 => 179, 2000 => 229, 2500 => 299]
            ],
            [
                "category" => "Manual Cheques",
                "subcategory" => "1 up Manual Burgundy",
                "image" => "tan.jpg",
                "prices" => [100 => 59, 250 => 79, 500 => 99, 1000 => 129, 1500 => 179, 2000 => 229, 2500 => 299]
            ],
            [
                "category" => "Manual Cheques",
                "subcategory" => "2 up Manual Blue",
                "image" => "Blue.jpg",
                "prices" => [100 => 59, 250 => 79, 500 => 99, 1000 => 129, 1500 => 179, 2000 => 229, 2500 => 299]
            ],
            [
                "category" => "Manual Cheques",
                "subcategory" => "2 up Manual Green",
                "image" => "green.jpg",
                "prices" => [100 => 59, 250 => 79, 500 => 99, 1000 => 129, 1500 => 179, 2000 => 229, 2500 => 299]
            ],
            [
                "category" => "Manual Cheques",
                "subcategory" => "2 up Manual Burgundy",
                "image" => "tan.jpg",
                "prices" => [100 => 59, 250 => 79, 500 => 99, 1000 => 129, 1500 => 179, 2000 => 229, 2500 => 299]
            ],
            [
                "category" => "Laser Cheques",
                "subcategory" => "Top Laser Green",
                "image" => "green.jpg",
                "prices" => [100 => 99, 250 => 119, 500 => 149, 1000 => 199, 1500 => 249, 2000 => 299, 2500 => 349]
            ],
            [
                "category" => "Laser Cheques",
                "subcategory" => "Top Laser Blue",
                "image" => "Blue.jpg",
                "prices" => [100 => 99, 250 => 119, 500 => 149, 1000 => 199, 1500 => 249, 2000 => 299, 2500 => 349]
            ],
            [
                "category" => "Laser Cheques",
                "subcategory" => "Top Laser Burgundy",
                "image" => "tan.jpg",
                "prices" => [100 => 99, 250 => 119, 500 => 149, 1000 => 199, 1500 => 249, 2000 => 299, 2500 => 349]
            ],
            [
                "category" => "Laser Cheques",
                "subcategory" => "Top Laser Brown",
                "image" => "tan.jpg",
                "prices" => [100 => 99, 250 => 119, 500 => 149, 1000 => 199, 1500 => 249, 2000 => 299, 2500 => 349]
            ],
            [
                "category" => "Hologram Cheques",
                "subcategory" => "Top Laser Blue Hologram",
                "image" => "Blue.jpg",
                "prices" => [100 => 129, 250 => 149, 500 => 199, 1000 => 249, 1500 => 299, 2000 => 379, 2500 => 449]
            ],
            [
                "category" => "Hologram Cheques",
                "subcategory" => "Top Laser Brown Hologram",
                "image" => "tan.jpg",
                "prices" => [100 => 129, 250 => 149, 500 => 199, 1000 => 249, 1500 => 299, 2000 => 379, 2500 => 449]
            ],
        ];

        // Step 3: Create Categories, Subcategories, and Pricing
        $categoryOrder = [];

        foreach ($products as $index => $product) {
            // Create or get category
            $category = Category::firstOrCreate(
                ['name' => $product['category']],
                ['slug' => Str::slug($product['category']), 'is_active' => true]
            );

            // Track display order for subcategories within each category
            if (!isset($categoryOrder[$category->id])) {
                $categoryOrder[$category->id] = 1;
            }

            // Create subcategory
            $subcategory = Subcategory::firstOrCreate(
                ['name' => $product['subcategory']],
                [
                    'slug' => Str::slug($product['subcategory']),
                    'image' => $product['image'],
                    'is_active' => true
                ]
            );

            // Link subcategory to category (if not already linked)
            if (!$category->subcategories()->where('subcategory_id', $subcategory->id)->exists()) {
                $category->subcategories()->attach($subcategory->id, [
                    'display_order' => $categoryOrder[$category->id]++
                ]);
            }

            // Create pricing for each quantity tier
            foreach ($product['prices'] as $quantity => $price) {
                if (isset($tierIds[$quantity])) {
                    Pricing::updateOrCreate(
                        [
                            'subcategory_id' => $subcategory->id,
                            'quantity_tier_id' => $tierIds[$quantity],
                        ],
                        [
                            'price' => $price,
                        ]
                    );
                }
            }
        }

        $this->command->info('Product data seeded successfully!');
        $this->command->info('Categories: ' . Category::count());
        $this->command->info('Subcategories: ' . Subcategory::count());
        $this->command->info('Quantity Tiers: ' . QuantityTier::count());
        $this->command->info('Pricing Entries: ' . Pricing::count());
    }
}
