<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'title' => ucfirst($this->faker->unique()->word()),
            'description' => $this->faker->text,
            'image' => env('APP_URL') . '/images/test.jpg',
            'price' => $this->faker->randomDigit()
        ];
    }
}
