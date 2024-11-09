<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Budi Arif',
            'role_id' => 1,
            'email' => 'petugas1@rpjm',
            'password' => '12345678'
        ]);
        User::create([
            'name' => 'Arif Budi',
            'role_id' => 2,
            'email' => 'admin1@rpjm',
            'password' => '12345678'
        ]);
    }
}
