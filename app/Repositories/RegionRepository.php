<?php

namespace App\Repositories;

use App\Models\Region;

class RegionRepository
{
    public function getAll()
    {
        return Region::with('parent')->get();
    }

    public function getAllTree()
    {
        return Region::whereNull('parent_id')
            ->with('childrenRecursive')
            ->get();
    }

}
