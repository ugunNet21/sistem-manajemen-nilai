<?php

namespace Database\Seeders;

use App\Models\Nilai;
use App\Models\Siswa;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $siswas = Siswa::all()->keyBy('nama');

        $grades = [
            ['siswa' => 'Andi',  'mapel' => 'Matematika', 'nilai' => 80],
            ['siswa' => 'Andi',  'mapel' => 'Bahasa',     'nilai' => 70],
            ['siswa' => 'Budi',  'mapel' => 'Matematika', 'nilai' => 60],
            ['siswa' => 'Budi',  'mapel' => 'Bahasa',     'nilai' => 75],
            ['siswa' => 'Citra', 'mapel' => 'Matematika', 'nilai' => 90],
            ['siswa' => 'Citra', 'mapel' => 'Bahasa',     'nilai' => 85],
        ];

        foreach ($grades as $gradeData) {
            // Cek apakah siswa dengan nama tersebut ada
            if (isset($siswas[$gradeData['siswa']])) {
                $siswa = $siswas[$gradeData['siswa']];

                Nilai::updateOrCreate(
                    [
                        'siswa_id' => $siswa->id,
                        'mapel'    => $gradeData['mapel'],
                    ],
                    [
                        'kelas' => $siswa->kelas, 
                        'nilai' => $gradeData['nilai'],
                    ]
                );
            }
        }

        $this->command->info('GradeSeeder selesai dijalankan.');
    }
}