<?php

namespace Database\Seeders;

use App\Models\Laporan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'judul' => 'Laporan Pertama',
                'progres' => 0,
                'deskripsi' => 'Ini Laporan Pertama lur',
            ],
            [
                'judul' => 'Laporan Kedua',
                'progres' => 25,
                'deskripsi' => 'Ini Laporan Kedua Lur',
            ],
            [
                'judul' => 'Laporan Ketiga',
                'progres' => 50,
                'deskripsi' => 'Ini Laporan Ketiga Lur',
            ],
        ];

        for ($i=1; $i < 84; $i++) {
            for ($j=0; $j < 3; $j++) {
                Laporan::create([
                    'id_kegiatan' => $i,
                    'judul' => $data[$j]['judul'],
                    'progres' => $data[$j]['progres'],
                    'deskripsi' => $data[$j]['deskripsi'],
                ]);
            }
        }
    }
}
