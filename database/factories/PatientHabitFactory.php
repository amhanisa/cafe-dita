<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PatientHabit>
 */
class PatientHabitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'patient_id' => 1,
            'habit_id' => 1,
            'year' => 2022,
            'month' => 1,
            'week1' => fake()->boolean(),
            'week2' => fake()->boolean(),
            'week3' => fake()->boolean(),
            'week4' => fake()->boolean(),
            'note' => fake()->sentence()
        ];
    }
}
