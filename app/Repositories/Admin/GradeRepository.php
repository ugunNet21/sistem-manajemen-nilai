<?php

namespace App\Repositories\Admin;

use App\Models\Nilai as Grade;
use App\Repositories\Contracts\Admin\GradeRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GradeRepository implements GradeRepositoryInterface
{
    protected $model;

    public function __construct(Grade $model)
    {
        $this->model = $model;
    }

    public function getFilteredPaginated(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->model->with('siswa')->latest('created_at');

        if (!empty($filters['kelas'])) {
            $query->whereHas('siswa', function ($q) use ($filters) {
                $q->where('kelas', $filters['kelas']);
            });
        }
        if (!empty($filters['mapel'])) {
            $query->where('mapel', $filters['mapel']);
        }
        if (!empty($filters['grade'])) {
            $query->byGrade($filters['grade']);
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function find(string $id)
    {
        return $this->model->with('siswa')->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(string $id, array $data)
    {
        $record = $this->find($id);
        $record->update($data);
        return $record;
    }

    public function delete(string $id)
    {
        $record = $this->find($id);
        return $record->delete();
    }

    // not used anymore, but we keep it for interface consistency
    public function all()
    {
        return $this->model->with('siswa')->get();
    }
}
