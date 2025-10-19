<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class StudentReportController extends Controller
{
    /**
     * Export PDF raport siswa
     */
    public function exportPdf(string $id): Response
    {
        $student = Siswa::with(['nilai'])->findOrFail($id);

        // Menghitung statistik untuk ditampilkan di raport
        $student->rata_rata = $student->getRataRataAttribute();
        $student->grade = $student->getGradeAttribute();
        $student->nilai_count = $student->nilai->count();
        $student->nilai_tertinggi = $student->nilai->max('nilai') ?? 0;
        $student->nilai_terendah = $student->nilai->min('nilai') ?? 0;

        // Mengelompokkan nilai berdasarkan mata pelajaran dan menghitung statistik per mapel
        $nilaiPerMapel = $student->nilai->groupBy('mapel')->map(function ($nilaiGroup) {
            return [
                'rata_rata' => $nilaiGroup->avg('nilai'),
                'nilai_tertinggi' => $nilaiGroup->max('nilai'),
                'nilai_terendah' => $nilaiGroup->min('nilai'),
                'total_nilai' => $nilaiGroup->count(),
                'detail' => $nilaiGroup
            ];
        });

        $data = [
            'student' => $student,
            'nilaiPerMapel' => $nilaiPerMapel,
            'tanggal' => now()->translatedFormat('d F Y'),
            'tahunAjaran' => now()->year . '/' . (now()->year + 1)
        ];

        $pdf = Pdf::loadView('admin.students.report-pdf', $data)
            ->setPaper('F4', 'portrait');

        return $pdf->download("raport-{$student->nama}-{$student->kelas}.pdf");
    }

    /**
     * Preview PDF sebelum download
     */
    public function previewPdf(string $id)
    {
        $student = Siswa::with(['nilai'])->findOrFail($id);

        $student->rata_rata = $student->getRataRataAttribute();
        $student->grade = $student->getGradeAttribute();
        $student->nilai_count = $student->nilai->count();
        $student->nilai_tertinggi = $student->nilai->max('nilai') ?? 0;
        $student->nilai_terendah = $student->nilai->min('nilai') ?? 0;

        $nilaiPerMapel = $student->nilai->groupBy('mapel')->map(function ($nilaiGroup) {
            return [
                'rata_rata' => $nilaiGroup->avg('nilai'),
                'nilai_tertinggi' => $nilaiGroup->max('nilai'),
                'nilai_terendah' => $nilaiGroup->min('nilai'),
                'total_nilai' => $nilaiGroup->count(),
                'detail' => $nilaiGroup
            ];
        });

        $data = [
            'student' => $student,
            'nilaiPerMapel' => $nilaiPerMapel,
            'tanggal' => now()->translatedFormat('d F Y'),
            'tahunAjaran' => now()->year . '/' . (now()->year + 1)
        ];

        return view('admin.students.report-pdf', $data);
    }
}