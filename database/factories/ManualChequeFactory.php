<?php


namespace Database\Factories;

use App\Models\ManualCheque;
use Illuminate\Database\Eloquent\Factories\Factory;

class ManualChequeFactory extends Factory
{
    protected $model = ManualCheque::class;

    public function definition()
    {
        return [
            'categoriesName' => $this->faker->sentence, // You can customize this if needed
            'img' => $this->faker->imageUrl(), // Or provide a specific default
        ];
    }
}
