<?php

namespace Database\Seeders;

use App\Models\Consultation;
use App\Models\Patient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConsultationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $patients = Patient::all();

        $data = [];

        foreach ($patients as $patient) {
            foreach (range(1, 20) as $index) {
                $data[] = [
                    'patient_id' => $patient->id,
                    'date' => fake()->dateTimeInInterval('-2 years', '+2 years'),
                    'systole' => fake()->numberBetween(100, 150),
                    'diastole' => fake()->numberBetween(60, 100),
                    'medicine' => fake()->sentence(),
                    'note' => fake()->sentence(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        foreach (array_chunk($data, 1000) as $chunk) {
            Consultation::insert($chunk);
        }
    }
}
