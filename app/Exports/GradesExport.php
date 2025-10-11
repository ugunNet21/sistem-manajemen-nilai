<?php

namespace App\Exports;

use App\Models\Nilai;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\Log;

class GradesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection(): Collection
    {
        $query = Nilai::with('siswa');

        if (!empty($this->filters['kelas'])) {
            $query->where('kelas', $this->filters['kelas']);
        }
        if (!empty($this->filters['mapel'])) {
            $query->where('mapel', $this->filters['mapel']);
        }
        if (!empty($this->filters['grade'])) {
            $query->where('grade', $this->filters['grade']); // grade is an appended attribute
        }

        $data = $query->get();
        // Log::info('Exporting ' . $data->count() . ' records with filters: ' . json_encode($this->filters));

        return $data;
    }

    public function headings(): array
    {
        return [
            'Nama Siswa',
            'Kelas',
            'Mata Pelajaran',
            'Nilai',
        ];
    }

    public function map($nilai): array
    {
        return [
            $nilai->siswa->nama ?? 'N/A',
            $nilai->kelas ?? 'N/A',
            $nilai->mapel,
            $nilai->nilai,
        ];
    }
}