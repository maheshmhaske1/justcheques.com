<?php


namespace Database\Factories;

use App\Models\PersonalCheque;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonalChequeFactory extends Factory
{
    protected $model = PersonalCheque::class;

    public function definition()
    {
        return [
            'categoriesName' => $this->faker->word,
            'img' => $this->faker->imageUrl(), // You can customize this if needed
        ];
    }
}
