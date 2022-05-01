<?php

namespace App\Services;

use App\Repositories\VideoElasticsearchSearchRepository;

class VideoStatisticService
{
    public function __construct(private VideoElasticsearchSearchRepository $repository)
    {
    }

    public function getData(string $title): array
    {
        $params = [
            'index' => VideoElasticsearchSearchRepository::INDEX,
            'body'  => [
                'query' => [
                    'match' => [
                        'video_chanel' => $title,
                    ]
                ]
            ]
        ];

        return $this->repository->search($params);
    }

    public function likes(array $result): int
    {
        $sum = 0;

        foreach ($result['hits']['hits'] as $video) {
            $sum += $video['_source']['like'];
        }

        return $sum;
    }

    public function dislikes(array $result): int
    {
        $sum = 0;

        foreach ($result['hits']['hits'] as $video) {
            $sum += $video['_source']['dislike'];
        }

        return $sum;
    }
}
