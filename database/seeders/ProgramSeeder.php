<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_bidang' => 1,
                'nama' => 'Penyelenggaraan Paud/TK/TPA/TKA',
                'cangkupan_program' => 'Kalurahan Tirtomulyo',
            ],
            [
                'id_bidang' => 1,
                'nama' => 'Penyuluhan dan Pelatihan Pendidikan bagi Masyarakat',
                'cangkupan_program' => 'Kalurahan Tirtomulyo',
            ],
            [
                'id_bidang' => 1,
                'nama' => 'Pembangunan/Rehabilitasi/Peningkatan/Pengadaan Sarana/Prasarana/ Alat Peragag TK, PAUD/TPA/TPQ',
                'cangkupan_program' => 'Kalurahan Tirtomulyo',
            ],
            [
                'id_bidang' => 1,
                'nama' => 'Pengelolaan Perpustakaan Milik Desa',
                'cangkupan_program' => 'Kalurahan Tirtomulyo',
            ],
            [
                'id_bidang' => 1,
                'nama' => 'Dukungan Pendidikan Bagi Siswa Miskin/Berprestasi',
                'cangkupan_program' => 'Kalurahan Tirtomulyo',
            ],
            [
                'id_bidang' => 2,
                'nama' => 'Penyelenggaraan POSYANDU [PMT]',
                'cangkupan_program' => 'Kalurahan Tirtomulyo',
            ],
            [
                'id_bidang' => 2,
                'nama' => 'Penyuluhan dan Pelatihan Bidang Kesehatan (utk Masyarakat, Tenaga dan Kader Kesehatan)',
                'cangkupan_program' => 'Kalurahan Tirtomulyo',
            ],
            [
                'id_bidang' => 2,
                'nama' => 'Penyelenggaraan Desa Siaga Kesehatan',
                'cangkupan_program' => 'Kalurahan Tirtomulyo',
            ],
            [
                'id_bidang' => 2,
                'nama' => 'Pengasuhan Bersama atau Bina Keluarga Balita',
                'cangkupan_program' => 'Kalurahan Tirtomulyo',
            ],
            [
                'id_bidang' => 2,
                'nama' => 'Pembangunan/Rehabilitasi/Peningkatan/Pengadaan Sarana/Prasarana Posyandu/polindes/PKD',
                'cangkupan_program' => '15 Padukuhan',
            ],
            [
                'id_bidang' => 2,
                'nama' => 'Pengelolaan Rumah Keluarga Sehat',
                'cangkupan_program' => 'Kalurahan Tirtomulyo',
            ],
            [
                'id_bidang' => 2,
                'nama' => 'Pembinaan kampung KB',
                'cangkupan_program' => 'Karangweru',
            ],
            [
                'id_bidang' => 2,
                'nama' => 'Pengeloaan Kalurahan Inklusi',
                'cangkupan_program' => 'Kalurahan Tirtomulyo',
            ],
            [
                'id_bidang' => 2,
                'nama' => 'Penanganan / Pemulihan Balita Gizi Buruk / Stunting',
                'cangkupan_program' => 'Kalurahan Tirtomulyo',
            ],
            [
                'id_bidang' => 2,
                'nama' => 'Pendampingan Ibu Hamil Kekurangan Gizi Kronis / Risiko Tinggi dan Nifas',
                'cangkupan_program' => 'Kalurahan Tirtomulyo',
            ],
            [
                'id_bidang' => 2,
                'nama' => 'Gerakan Kebersihan dan Kesehatan Lingkungan (PSN)',
                'cangkupan_program' => '15 Padukuhan',
            ],
            [
                'id_bidang' => 3,
                'nama' => 'Pembangunan/Rehabilitasi/Peningkatan/Pengerasan Jalan Desa',
                'cangkupan_program' => 'Kalurahan Tirtomulyo',
            ],
            [
                'id_bidang' => 3,
                'nama' => 'Pembangunan/Rehabilitasi/Peningkatan/Pengerasan Jalan Lingkungan',
                'cangkupan_program' => 'Kalurahan Tirtomulyo',
            ],
            [
                'id_bidang' => 3,
                'nama' => 'Pembangunan/Rehabilitasi/Peningkatan/Pengerasan Jalan Usaha Tani',
                'cangkupan_program' => 'Kalurahan Tirtomulyo',
            ],
            [
                'id_bidang' => 3,
                'nama' => 'Pembangunan/Rehabilitasi/Peningkatan/Pengerasan Jembatan Milik Desa',
                'cangkupan_program' => 'Kalurahan Tirtomulyo',
            ],
            [
                'id_bidang' => 3,
                'nama' => 'Pembangunan/Rehabilitasi/Peningkatan Prasarana Jalan Desa (Gorong, Selokan dll)',
                'cangkupan_program' => 'Kalurahan Tirtomulyo',
            ],
            [
                'id_bidang' => 3,
                'nama' => 'Pembangunan/Rehabilitasi/Peningkatan Balai Desa/Balai Kemasyarakatan',
                'cangkupan_program' => 'Kalurahan Tirtomulyo',
            ],
            [
                'id_bidang' => 3,
                'nama' => 'Pembangunan/Rehabilitasi/Peningkatan Pemakaman/Situs Bersejarah/Petilasan',
                'cangkupan_program' => 'Kalurahan Tirtomulyo',
            ],
            [
                'id_bidang' => 3,
                'nama' => 'PPembangunan/Rehabilitasi/Peningkatan Monumen/Gapura/Batas Desa',
                'cangkupan_program' => 'Kalurahan Tirtomulyo',
            ],
            [
                'id_bidang' => 3,
                'nama' => 'Pembangunan / Pengembangan Kawasan Budaya Kalurahan',
                'cangkupan_program' => 'Kalurahan Tirtomulyo',
            ],
            [
                'id_bidang' => 3,
                'nama' => 'Pembangunan Area Bermain Anak Untuk Mendukung Kalurahan Layak Anak',
                'cangkupan_program' => 'Kalurahan Tirtomulyo',
            ],
            [
                'id_bidang' => 4,
                'nama' => 'Pembangunan/Rehabilitasi RTLH',
                'cangkupan_program' => 'Kalurahan Tirtomulyo',
            ],
            [
                'id_bidang' => 4,
                'nama' => 'Pemeliharaan Sanitasi Pemukiman (Gorong-Gorong, Selokan, Parit di luar prasarana Jalan)',
                'cangkupan_program' => 'Kalurahan Tirtomulyo',
            ],
            [
                'id_bidang' => 4,
                'nama' => 'Pembangunan/Rehabilitasi/Peningkatan Fasilitas Jamban Umum/MCK Umum',
                'cangkupan_program' => '15 Padukuhan',
            ],
            [
                'id_bidang' => 4,
                'nama' => 'Pembangunan/Rehabilitasi/Peningkatan Fasilitas Pengelolaan Sampah',
                'cangkupan_program' => 'Kalurahan Tirtomulyo',
            ],
            [
                'id_bidang' => 4,
                'nama' => 'Pembangunan/Rehabilitasi/Peningkatan Taman/Taman Bermain Anak Milik Desa',
                'cangkupan_program' => 'Kalurahan Tirtomulyo',
            ],
            [
                'id_bidang' => 4,
                'nama' => 'Pengelolaan PAMSIMAS',
                'cangkupan_program' => 'Kalurahan Tirtomulyo',
            ],
            [
                'id_bidang' => 4,
                'nama' => 'Pembangunan/Rehabilitasi/Pemeliharaan/Peningkatan IPAL Komunal',
                'cangkupan_program' => 'Kalurahan Tirtomulyo',
            ],
            [
                'id_bidang' => 4,
                'nama' => 'Bantuan Listrik untuk Masyarakat Miskin',
                'cangkupan_program' => 'Gondangan',
            ],
            [
                'id_bidang' => 4,
                'nama' => 'Pembangunan Taman/Rehab/Pemeliharaan Taman',
                'cangkupan_program' => 'Genting',
            ],
            [
                'id_bidang' => 5,
                'nama' => 'Pengelolaan Rumah Pilah Sampah / Bank Sampah Milik Kalurahan',
                'cangkupan_program' => 'Kalurahan Tirtomulyo',
            ],
            [
                'id_bidang' => 5,
                'nama' => 'Pelatihan Pengelolaan / Pengolahan Sampah',
                'cangkupan_program' => 'Kalurahan Tirtomulyo',
            ],
            [
                'id_bidang' => 5,
                'nama' => 'Pengembangan Tanaman Hias/Tanaman Obat/Sayuran di Pekarangan',
                'cangkupan_program' => 'Kalurahan Tirtomulyo',
            ],
            [
                'id_bidang' => 6,
                'nama' => 'Pembuatan rambu-rambu di jalan desa',
                'cangkupan_program' => 'Kalurahan Tirtomulyo',
            ],
            [
                'id_bidang' => 6,
                'nama' => 'Penyelenggaraan Informasi Publik Desa (Poster, Baliho)',
                'cangkupan_program' => 'Kalurahan Tirtomulyo',
            ],
            [
                'id_bidang' => 6,
                'nama' => 'Pengelolaan dan Pembuatan  Jaringan/Instalasi Komunikasi dan Informasi Lokal Desa',
                'cangkupan_program' => 'Kalurahan Tirtomulyo',
            ],
            [
                'id_bidang' => 6,
                'nama' => 'Pengembangan/Peningkatan/Pengadaan Sarana Penerangan Jalan',
                'cangkupan_program' => 'Kalurahan Tirtomulyo',
            ],
            [
                'id_bidang' => 7,
                'nama' => 'Pembangunan/Rehabilitasi/Peningkatan sarana dan Prasarana Pariwisata',
                'cangkupan_program' => 'Kalurahan Tirtomulyo',
            ],
            [
                'id_bidang' => 7,
                'nama' => 'Pengembangan Pariwisata tingkat Desa',
                'cangkupan_program' => 'Kalurahan Tirtomulyo',
            ],
        ];

        foreach ($data as $program) {
            Program::create([
                'id_bidang' => $program['id_bidang'],
                'nama' => $program['nama'],
                'cangkupan_program' => $program['cangkupan_program'],
            ]);
        }
    }
}
