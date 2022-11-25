<?php

namespace Database\Factories;

use App\Models\Village;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $genders = ['male' => 'L', 'female' => 'P'];
        $gender = array_rand($genders);

        return [
            'name' => fake()->name($gender),
            'medical_record_number' => fake()->unique()->numberBetween(10000, 99999),
            'nik' => fake()->nik(),
            'sex' => $genders[$gender],
            'birthday' => fake()->dateTimeInInterval('-70 years', '+55 years'),
            'address' => fake()->streetAddress(),
            'village_id' => fake()->numberBetween(1, 12),
            'phone_number' => fake()->phoneNumber(),
            'job' => fake()->jobTitle(),
        ];
    }
}
