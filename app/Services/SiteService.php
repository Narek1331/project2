<?php

namespace App\Services;

use App\Models\Site;
use App\Repositories\SiteRepository;

class SiteService
{
    public function __construct(
        protected SiteRepository $siteRepository
    ) {}

    /**
     * Создаёт сайт, если ещё не существует для пользователя
     *
     * @param int $userId
     * @param string $domain
     * @param string $region
     * @return Site|null
     */
    public function store(int $userId, string $domain, $region = null, $city = null): ?Site
    {

        return $this->siteRepository->create([
            'user_id' => $userId,
            'domain' => $domain,
            'region' => $region,
            'city' => $city,
            'click_in_hour' => 0,
            'click_per_day' => 0,
            'clean_click_in_hour' => 0,
            'clean_click_per_day' => 0,
            'status' => 0,
        ]);
    }

    /**
     * Получить все сайты текущего пользователя
     */
    public function getAllByUser(int $userId)
    {
        return $this->siteRepository->getAllByUser($userId);
    }

    public function updateStatus(int $id, $status = null): bool
    {
        return $this->siteRepository->updateStatus($id, $status);
    }

    public function getById(int $id)
    {
        return $this->siteRepository->getById($id);
    }

    public function update(int $id,$data)
    {
        $site = $this->getById($id);

        $this->siteRepository->update($site,[
            'domain' => $data['domain'],
            'region' => $data['region'],
            'city' => $data['city'],
        ]);

        if(isset($data['keywords']) && $data['keywords'])
        {
            $ids = collect($data['keywords'])
            ->filter(fn($item) => isset($item['id']))
            ->pluck('id')
            ->all();

            $site->keywords()->whereNotIn('id',$ids)->delete();

            foreach($data['keywords'] as $keyword)
            {
                if(isset($keyword['name']))
                {
                    if(isset($keyword['id']))
                    {
                        $keywordData = $site->keywords()->find($keyword['id']);

                        $keywordData->update([
                            'name' => $keyword['name'] ?? null,
                            'url' => $keyword['url'] ?? null,
                            'clicks_per_day' => $keyword['clicks_per_day'] ?? null
                        ]);

                    }else{
                        $site->keywords()->create([
                            'name' => $keyword['name'] ?? null,
                            'url' => $keyword['url'] ?? null,
                            'clicks_per_day' => $keyword['clicks_per_day'] ?? null
                        ]);
                    }
                }

            }


        }
        // return $this->siteRepository->getById($id);
    }

}
