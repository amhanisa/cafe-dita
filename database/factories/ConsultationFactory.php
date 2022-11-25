<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Consultation>
 */
class ConsultationFactory extends Factory
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
            'date' => fake()->dateTimeInInterval('-2 years', '+2 years'),
            'systole' => fake()->numberBetween(100, 150),
            'diastole' => fake()->numberBetween(60, 100),
            'medicine' => fake()->sentence(),
            'note' => fake()->sentence()
        ];
    }
}
