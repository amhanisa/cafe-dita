<?php

namespace Database\Seeders;

use App\Models\Consultation;
use App\Models\Patient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genders = ['male' => 'L', 'female' => 'P'];
        $gender = array_rand($genders);

        $data = [];

        foreach (range(1, 4000) as $index) {
            $data[] = [
                'name' => fake()->name($gender),
                'medical_record_number' => fake()->unique()->numberBetween(10000, 99999),
                'nik' => fake()->nik(),
                'sex' => fake()->randomElement($genders),
                'birthday' => fake()->dateTimeInInterval('-70 years', '+55 years'),
                'address' => fake()->streetAddress(),
                'village_id' => fake()->numberBetween(1, 12),
                'phone_number' => fake()->phoneNumber(),
                'job' => fake()->jobTitle(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        foreach (array_chunk($data, 1000) as $chunk) {
            Patient::insert($chunk);
        }
    }
}
