<?php

namespace App\Services;

use App\Repositories\AdminParamRepository;
use App\Models\AdminParam;

class AdminParamService
{
    protected AdminParamRepository $adminParamRepository;

    public function __construct(AdminParamRepository $adminParamRepository)
    {
        $this->adminParamRepository = $adminParamRepository;
    }

    public function get()
    {
        return $this->adminParamRepository->get();
    }
}
