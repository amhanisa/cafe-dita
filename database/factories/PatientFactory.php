<?php

namespace Database\Factories;

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
        $villages = [
            'Buluagung',
            'Jati',
            'Jatiprahu',
            'Karangan',
            'Kayen',
            'Kedungsigit',
            'Kerjo',
            'Ngentrong',
            'Salamrejo',
            'Suko Wetan',
            'Sumber',
            'Sumberingin',
        ];

        return [
            'name' => fake("id_ID")->name(),
            'medical_record_number' => fake()->unique()->numberBetween(10000, 99999),
            'nik' => fake('id_ID')->nik(),
            'sex' => fake()->randomElement(['L', 'P']),
            'birthday' => fake()->dateTimeInInterval('-70 years', '+55 years'),
            'address' => fake('id_ID')->streetAddress(),
            'village' => fake()->randomElement($villages),
            'phone_number' => fake('id_ID')->phoneNumber(),
            'job' => fake('id_ID')->jobTitle(),
        ];
    }
}
