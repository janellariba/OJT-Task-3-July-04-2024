<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class StudentsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstname(),
            'last_name' => fake()->lastname(),
            'gender' => fake()->randomElement(['Male', 'Female']),
            'age' => fake()->numberBetween($min = 18 , $max = 22),
            'email' => fake()->safeEmail(),
        ];
    }
}
