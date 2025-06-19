<?php

namespace App\Services;

use App\Repositories\RegionRepository;

class RegionService
{
    protected RegionRepository $regionRepository;

    public function __construct(RegionRepository $regionRepository)
    {
        $this->regionRepository = $regionRepository;
    }

    public function getAllRegions()
    {
        return $this->regionRepository->getAll();
    }

    public function getAllTree()
    {
        return $this->regionRepository->getAllTree();
    }
}
