<?php

namespace Database\Seeders;

use App\Models\Habit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HabitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Habit::create([
            'name' => 'Makan Buah & Sayur'
        ]);
        Habit::create([
            'name' => 'Rutin Olahraga'
        ]);
        Habit::create([
            'name' => 'Merokok'
        ]);
        Habit::create([
            'name' => 'Rutin Minum Obat'
        ]);
    }
}
