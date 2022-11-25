<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\PatientHabit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\LazyCollection;

class PatientHabitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $patients = Patient::all();

        foreach ($patients->chunk(10) as $chunks) {
            $data = [];
            foreach ($chunks as $patient) {
                foreach (range(1, 10) as $month) {
                    foreach (range(1, 4) as $habit) {
                        $data[] = [
                            'patient_id' => $patient->id,
                            'habit_id' => $habit,
                            'year' => 2022,
                            'month' => $month,
                            'week1' => fake()->boolean(),
                            'week2' => fake()->boolean(),
                            'week3' => fake()->boolean(),
                            'week4' => fake()->boolean(),
                            'note' => fake()->sentence(),
                            'created_at' => now(),
                            'updated_at' => now()
                        ];
                    }
                }
            }
            PatientHabit::insert($data);
        }
    }
}
