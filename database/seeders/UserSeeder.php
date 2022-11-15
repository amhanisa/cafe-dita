<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'amhanisa',
            'name' => 'Azka Muhammad Hanisa',
            'password' => Hash::make('amhanisa'),
            'role_id' => 1
        ]);
        User::create([
            'username' => 'kader',
            'name' => 'Kader Cafe DITA',
            'password' => Hash::make('kader'),
            'role_id' => 2
        ]);
    }
}
