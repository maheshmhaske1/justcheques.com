<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ChequeCategories;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ChequeCategoriesFactory extends Factory
{
    protected $model = ChequeCategories::class;

    public function definition()
    {
        return [
            'manual_cheque_id' => $this->faker->randomDigit, // Adjust according to your needs
            'laser_cheque_id' => $this->faker->randomDigit,  // Adjust according to your needs
            'chequeName' => $this->faker->word,
            'price' => $this->faker->randomFloat(2, 1, 100), // Random price between 1 and 100
            'img' => $this->faker->imageUrl(), // Generate a random image URL
        ];
    }
}
