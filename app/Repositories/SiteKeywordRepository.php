<?php

namespace App\Repositories;

use App\Models\{
    SiteKeyword
};
use Illuminate\Database\Eloquent\Collection;

class SiteKeywordRepository
{
    public function create(array $data): SiteKeyword
    {
        return SiteKeyword::create($data);
    }
}
