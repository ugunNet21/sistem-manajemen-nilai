<?php

namespace App\Repositories\Admin;

use App\Models\Siswa as Student;
use App\Repositories\Contracts\Admin\StudentRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class StudentRepository implements StudentRepositoryInterface
{
    protected $model;

    public function __construct(Student $model)
    {
        $this->model = $model;
    }

    public function all(): LengthAwarePaginator
    {
        return $this->model
            ->withCount('nilai')
            ->latest()
            ->paginate(10);
    }

    public function find(string $id): Student
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data): Student
    {
        return $this->model->create($data);
    }

    public function update(string $id, array $data): Student
    {
        $record = $this->find($id);
        $record->update($data);
        return $record;
    }

    public function delete(string $id): bool
    {
        $record = $this->find($id);
        return $record->delete();
    }
}
