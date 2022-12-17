<?php

namespace Database\Seeders;

use App\Models\Consultation;
use App\Models\Patient;
use Carbon\Carbon;
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
            $startDate = Carbon::now();
            foreach (range(1, 20) as $index) {
                $data[] = [
                    'patient_id' => $patient->id,
                    // 'date' => $startDate->subDays(fake()->numberBetween(1, 15))->subMonths(fake()->numberBetween(0, 2))->format('Y-m-d'),
                    'date' => $startDate->subMonths(fake()->numberBetween(1, 2))->format('Y-m-d'),
                    'systole' => fake()->numberBetween(100, 145),
                    'diastole' => fake()->numberBetween(60, 95),
                    'medicine' => fake()->sentence(),
                    'note' => fake()->sentence(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        foreach (array_chunk($data, 100) as $chunk) {
            Consultation::insert($chunk);
        }
    }
}
