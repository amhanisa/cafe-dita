<?php

namespace Database\Seeders;

use App\Models\Village;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VillageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Village::create([
            'name' => 'Buluagung'
        ]);
        Village::create([
            'name' => 'Jati'
        ]);
        Village::create([
            'name' => 'Jatiprahu'
        ]);
        Village::create([
            'name' => 'Karangan'
        ]);
        Village::create([
            'name' => 'Kayen'
        ]);
        Village::create([
            'name' => 'Kedungsigit'
        ]);
        Village::create([
            'name' => 'Kerjo'
        ]);
        Village::create([
            'name' => 'Ngentrong'
        ]);
        Village::create([
            'name' => 'Salamrejo'
        ]);
        Village::create([
            'name' => 'Suko Wetan'
        ]);
        Village::create([
            'name' => 'Sumber'
        ]);
        Village::create([
            'name' => 'Sumberingin'
        ]);
    }
}
