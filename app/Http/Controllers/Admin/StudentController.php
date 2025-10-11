<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StudentRequest;
use App\Models\Siswa;
use App\Services\Admin\StudentService;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class StudentController extends Controller
{
    protected $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    /**
     * Menampilkan halaman daftar siswa.
     */
    public function index(): Response
    {
        $students = $this->studentService->all();
        
        // Menambahkan properti 'rata_rata' dan 'grade' ke setiap item siswa
        $students->getCollection()->transform(function ($student) {
            $student->rata_rata = $student->getRataRataAttribute();
            $student->grade = $student->getGradeAttribute();
            return $student;
        });

        return Inertia::render('Admin/Students/Index', [
            'students' => $students,
        ]);
    }

    /**
     * Menampilkan halaman form untuk menambah siswa baru.
     */
    public function create(): Response
    {
        return Inertia::render('Admin/Students/Create');
    }

    /**
     * Menyimpan data siswa baru ke database.
     */
    public function store(StudentRequest $request): RedirectResponse
    {
        $this->studentService->create($request->validated());

        return redirect()->route('admin.students.index')
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    /**
     * Menampilkan halaman form untuk mengedit data siswa.
     * Menggunakan Route-Model Binding untuk efisiensi.
     */
    public function edit(Siswa $id): Response
    {
        return Inertia::render('Admin/Students/Edit', [
            'student' => $id,
        ]);
    }

    /**
     * Memperbarui data siswa di database.
     */
    public function update(StudentRequest $request, string $id): RedirectResponse
    {
        $this->studentService->update($id, $request->validated());

        return redirect()->route('admin.students.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Menghapus data siswa dari database.
     */
    public function destroy(string $id): RedirectResponse
    {
        $this->studentService->delete($id);

        return redirect()->route('admin.students.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }
}
