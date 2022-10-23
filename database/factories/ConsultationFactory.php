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
            'patient_id' => fake()->randomElement(Patient::pluck('id')),
            'date' => fake()->dateTimeInInterval('-3 years', '+3 years'),
            'systole' => fake()->numberBetween(120, 200),
            'diastole' => fake()->numberBetween(70, 120),
            'medicine' => fake()->words(2, true),
            'note' => fake()->words(5, true)
        ];
    }
}
