<?php

namespace App\Repositories\Admin;

use App\Models\Nilai;
use App\Models\Siswa;
use App\Repositories\Contracts\Admin\DashboardRepositoryInterface;
use Illuminate\Support\Facades\DB;

class DashboardRepository implements DashboardRepositoryInterface
{
    public function getDashboardData(): array
    {
        // 1. Data untuk Kartu Statistik (Stats Cards)
        $stats = [
            'total_siswa' => Siswa::count(),
            'rata_rata_nilai' => (float) Nilai::avg('nilai'),
            'total_kelas' => Siswa::distinct()->count('kelas'),
            'total_mapel' => Nilai::distinct()->count('mapel'),
        ];

        // 2. Data untuk Chart Distribusi Grade
        $gradeDistribution = DB::table('nilai')
            ->select(
                DB::raw("CASE
                    WHEN nilai >= 85 THEN 'A'
                    WHEN nilai >= 70 THEN 'B'
                    WHEN nilai >= 60 THEN 'C'
                    ELSE 'D'
                END as grade, COUNT(*) as count")
            )
            ->groupBy('grade')
            ->orderBy('grade')
            ->get();

        // 3. Data untuk Chart Rata-rata per Mapel
        $averageBySubject = Nilai::select('mapel', DB::raw('AVG(nilai) as rata_rata'))
            ->groupBy('mapel')
            ->orderBy('rata_rata', 'desc')
            ->get();

        // 4. Data untuk Tabel Nilai Terbaru
        $recentGrades = Nilai::with('siswa')->latest()->take(5)->get();

        return [
            'stats' => $stats,
            'gradeDistribution' => $gradeDistribution,
            'averageBySubject' => $averageBySubject,
            'recentGrades' => $recentGrades,
        ];
    }
}
