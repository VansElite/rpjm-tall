<?php

namespace Database\Seeders;

use App\Models\Bidang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BidangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama' => 'Pendidikan',
            ],
            [
                'nama' => 'Kesehatan',
            ],
            [
                'nama' => 'Penataan Ruang',
            ],
            [
                'nama' => 'Kawasan Pemukiman',
            ],
            [
                'nama' => 'Lingkungan Hidup',
            ],
            [
                'nama' => 'Perhubungan dan InfoKom',
            ],
            [
                'nama' => 'Pariwisata',
            ]
        ];

        foreach($data as $bidang) {
            Bidang::create([
                'nama' => $bidang['nama'],
            ]);
        }
    }
}
