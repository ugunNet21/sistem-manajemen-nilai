<?php

namespace Database\Seeders;

use App\Models\Siswa;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = [
            ['nama' => 'Andi', 'kelas' => '7A'],
            ['nama' => 'Budi', 'kelas' => '7A'],
            ['nama' => 'Citra', 'kelas' => '7B'],
        ];

        foreach ($students as $studentData) {
            Siswa::updateOrCreate(
                ['nama' => $studentData['nama']], 
                ['kelas' => $studentData['kelas']]
            );
        }

        $this->command->info('StudentSeeder selesai dijalankan.');
    }
}
