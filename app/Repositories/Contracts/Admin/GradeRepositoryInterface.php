<?php

namespace App\Repositories\Contracts\Admin;

use App\Models\Nilai as Grade;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface GradeRepositoryInterface
{
    public function getFilteredPaginated(array $filters = [], int $perPage = 10): LengthAwarePaginator;
    public function all();
    public function find(string $id);
    public function create(array $data);
    public function update(string $id, array $data);
    public function delete(string $id);
}