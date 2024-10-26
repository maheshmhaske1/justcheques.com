<?php



namespace Database\Factories;

use App\Models\LaserCheque;
use Illuminate\Database\Eloquent\Factories\Factory;

class LaserChequeFactory extends Factory
{
    protected $model = LaserCheque::class;

    public function definition()
    {
        return [
            'categoriesName' => $this->faker->word,
            'img' => $this->faker->imageUrl(), // Customize this as needed
        ];
    }
}
