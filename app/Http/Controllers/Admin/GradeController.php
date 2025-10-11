<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GradeRequest;
use App\Models\Siswa;
use App\Models\Nilai;
use App\Repositories\Contracts\Admin\GradeRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GradesExport;
use App\Imports\GradesImport;
use Exception;
use Illuminate\Support\Facades\Log;

class GradeController extends Controller
{
    protected $repository;

    public function __construct(GradeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['kelas', 'mapel', 'grade']);

        return Inertia::render('Admin/Grades/Index', [
            'grades' => $this->repository->getFilteredPaginated($filters),
            'students' => Siswa::orderBy('nama')->get(['id', 'nama', 'kelas']),
            'filters' => $filters,
            'unique' => [
                'kelas' => Siswa::select('kelas')->distinct()->orderBy('kelas')->pluck('kelas'),
                'mapel' => Nilai::select('mapel')->distinct()->orderBy('mapel')->pluck('mapel'),
            ]
        ]);
    }

    public function store(GradeRequest $request)
    {
        $data = $request->validated();
        $siswa = Siswa::find($data['siswa_id']);
        $data['kelas'] = $siswa->kelas;

        $this->repository->create($data);

        return redirect()->route('admin.grades.index')->with('success', 'Data nilai berhasil ditambahkan.');
    }

    public function update(GradeRequest $request, string $id)
    {
        $data = $request->validated();
        $siswa = Siswa::find($data['siswa_id']);
        $data['kelas'] = $siswa->kelas;

        $this->repository->update($id, $data);

        return redirect()->route('admin.grades.index')->with('success', 'Data nilai berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $this->repository->delete($id);

        return redirect()->route('admin.grades.index')->with('success', 'Data nilai berhasil dihapus.');
    }

    public function export()
    {
        return Excel::download(new GradesExport, 'data-nilai-siswa.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);
    
        try {
            Excel::import(new GradesImport, $request->file('file'));
            // Log::info('Import completed successfully.');
        } catch (Exception $e) {
            // Log::error('Import error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat import: ' . $e->getMessage());
        }
    
        return redirect()->route('admin.grades.index')->with('success', 'Data nilai berhasil di-import.');
    }
}
