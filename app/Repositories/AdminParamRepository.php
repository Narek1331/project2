<?php

namespace App\Repositories;

use App\Models\{
    AdminParam
};
use Illuminate\Database\Eloquent\Collection;

class AdminParamRepository
{
    public function get()
    {
        return AdminParam::first();
    }
}
