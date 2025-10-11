<?php

namespace App\Services\Admin;

use App\Repositories\Contracts\Admin\DashboardRepositoryInterface;

class DashboardService
{
    protected $repository;

    public function __construct(DashboardRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getDashboardData(): array
    {
        return $this->repository->getDashboardData();
    }
}
