<?php

namespace App\Imports;

use App\Models\Nilai;
use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Log;

class GradesImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        // Log::info('Processing import row: ' . json_encode($row));

        $siswa = Siswa::where('nama', $row['nama_siswa'])->where('kelas', $row['kelas'])->first();

        if (!$siswa) {
            // Create siswa baru jika tidak ditemukan
            $siswa = Siswa::create([
                'nama' => $row['nama_siswa'],
                'kelas' => $row['kelas'],
            ]);
            // Log::info('Created new siswa: ' . $siswa->id . ' - ' . $siswa->nama);
        } else {
            // Log::info('Found existing siswa: ' . $siswa->id . ' - ' . $siswa->nama);
        }

        $nilai = Nilai::updateOrCreate(
            [
                'siswa_id' => $siswa->id,
                'mapel'    => $row['mata_pelajaran'],
            ],
            [
                'kelas' => $siswa->kelas,
                'nilai' => $row['nilai'],
            ]
        );
        // Log::info('Imported/Updated nilai: ' . $nilai->id . ' for mapel ' . $nilai->mapel);

        return $nilai;
    }

    public function rules(): array
    {
        return [
            'nama_siswa' => 'required|string',
            'kelas' => 'required|string',
            'mata_pelajaran' => 'required|string',
            'nilai' => 'required|integer|min:0|max:100',
        ];
    }
}