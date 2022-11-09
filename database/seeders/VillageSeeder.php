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
            'name' => 'BULUAGUNG'
        ]);
        Village::create([
            'name' => 'JATI'
        ]);
        Village::create([
            'name' => 'JATIPRAHU'
        ]);
        Village::create([
            'name' => 'KARANGAN'
        ]);
        Village::create([
            'name' => 'KAYEN'
        ]);
        Village::create([
            'name' => 'KEDUNGSIGIT'
        ]);
        Village::create([
            'name' => 'KERJO'
        ]);
        Village::create([
            'name' => 'NGENTRONG'
        ]);
        Village::create([
            'name' => 'SALAMREJO'
        ]);
        Village::create([
            'name' => 'SUKOWETAN'
        ]);
        Village::create([
            'name' => 'SUMBER'
        ]);
        Village::create([
            'name' => 'SUMBERINGIN'
        ]);
    }
}
