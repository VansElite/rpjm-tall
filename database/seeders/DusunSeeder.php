<?php

namespace Database\Seeders;

use App\Models\Dusun;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DusunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama' => 'Kal. Tirtomulyo',
            ],
            [
                'nama' => 'Plesan',
            ],
            [
                'nama' => 'Paliyan',
            ],
            [
                'nama' => 'Karen',
            ],
            [
                'nama' => 'Gondangan',
            ],
            [
                'nama' => 'Kergan',
            ],
            [
                'nama' => 'Bracan',
            ],
            [
                'nama' => 'Tokolan',
            ],
            [
                'nama' => 'Tluren',
            ],
            [
                'nama' => 'Gaten',
            ],
            [
                'nama' => 'Jebugan',
            ],
            [
                'nama' => 'Karangweru',
            ],
            [
                'nama' => 'Genting',
            ],
            [
                'nama' => 'Tokolan',
            ],
            [
                'nama' => 'Soropadan',
            ],
            [
                'nama' => 'Jetis',
            ],
            [
                'nama' => 'Punduhan',
            ],
        ];

        foreach($data as $dusun) {
            Dusun::create([
                'nama' => $dusun['nama'],
            ]);
        }
    }
}
