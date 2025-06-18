<?php

namespace App\Repositories;

use App\Models\Site;
use Illuminate\Database\Eloquent\Collection;

class SiteRepository
{
    public function create(array $data): Site
    {
        return Site::create($data);
    }

    public function findByUserAndDomain(int $userId, string $domain): ?Site
    {
        return Site::where('user_id', $userId)
                   ->where('domain', $domain)
                   ->first();
    }

    public function getAllByUser(int $userId): Collection
    {
        return Site::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function updateStatus(int $id, $status = null): bool
    {
        $site = $this->getById($id);

        if(!$status)
        {
            $status = !$site->status;
        }

        return $site->update([
            'status' => $status
        ]) ;


    }

    public function getById(int $id)
    {
        return Site::find($id);
    }

    public function update(Site $site, $data)
    {
        return $site->update($data);
    }
}
