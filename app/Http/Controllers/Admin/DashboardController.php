<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Services\Admin\DashboardService; // <-- Import Service
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class DashboardController extends Controller
{
    protected $service;

    public function __construct(DashboardService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $dashboardData = $this->service->getDashboardData();
        // Log::info('Data Grade Distribution untuk Chart:', $dashboardData['gradeDistribution']->toArray());

        return Inertia::render('Admin/Dashboard', [
            'stats' => $dashboardData['stats'],
            'gradeDistribution' => $dashboardData['gradeDistribution'],
            'averageBySubject' => $dashboardData['averageBySubject'],
            'recentGrades' => $dashboardData['recentGrades'],
            'students' => Siswa::orderBy('nama')->get(['id', 'nama', 'kelas']),
        ]);
    }
}
