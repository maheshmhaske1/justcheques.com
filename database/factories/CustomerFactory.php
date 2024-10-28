<?php


namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition()
    {
        return [
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'telephone' => $this->faker->phoneNumber,
            'company' => $this->faker->company,
            'suburb' => $this->faker->city,
            'buzzer_code' => $this->faker->word,
            'email' => $this->faker->unique()->safeEmail,
            'user_id' => $this->faker->numberBetween(1, 100), // Adjust the range as needed
            'city' => $this->faker->city,
            'postcode' => $this->faker->postcode,
            'state' => $this->faker->state,
            'country' => $this->faker->country,
        ];
    }
}
