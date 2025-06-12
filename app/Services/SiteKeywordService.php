<?php

namespace App\Services;

use App\Repositories\SiteKeywordRepository;
use App\Models\SiteKeyword;

class SiteKeywordService
{
    public function __construct(
        protected SiteKeywordRepository $keywordRepository
    ) {}

    /**
     *
     * @param int $siteId
     * @param string $name
     * @param string|null $url
     * @param int $clicksPerDay
     * @return SiteKeyword|null
     */
    public function store(int $siteId, string $name, ?string $url = null, int $clicksPerDay = 0): ?SiteKeyword
    {

        return $this->keywordRepository->create([
            'site_id' => $siteId,
            'name' => $name,
            'url' => $url,
            'clicks_per_day' => $clicksPerDay,
            'status' => 0,
        ]);
    }
}
