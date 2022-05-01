<?php

namespace App\Services;

use App\Repositories\VideoElasticsearchSearchRepository;

class VideoTopStatisticService
{
    public function __construct(private VideoElasticsearchSearchRepository $repository)
    {
    }

    public function calculateLikes(int $count): array
    {
        $params = [
            'index' => VideoElasticsearchSearchRepository::INDEX,
            'size' => 1000,
        ];

        $result = $this->repository->search($params);
        $likes = $this->sumLikes($result);

        return $this->range($likes, $count);
    }

    public function calculateDislikes(int $count): array
    {
        $params = [
            'index' => VideoElasticsearchSearchRepository::INDEX,
            'size' => 1000,
        ];

        $result = $this->repository->search($params);
        $dislikes = $this->sumDislikes($result);

        return $this->range($dislikes, $count);
    }

    private function sumLikes(array $result): array
    {
        $chanels = [];

        foreach ($result['hits']['hits'] as $video) {
            $chanel = $video['_source']['video_chanel'] ?? null;

            if ($chanel === null) {
                continue;
            }

            if (isset($chanels[$chanel])) {
                $sum = $chanels[$chanel];
            } else {
                $sum = 0;
            }

            $sum += $video['_source']['like'];

            $chanels[$chanel] = $sum;
        }

        return $chanels;
    }

    private function sumDislikes(array $result): array
    {
        $chanels = [];

        foreach ($result['hits']['hits'] as $video) {
            $chanel = $video['_source']['video_chanel'] ?? null;

            if ($chanel === null) {
                continue;
            }

            if (isset($chanels[$chanel])) {
                $sum = $chanels[$chanel];
            } else {
                $sum = 0;
            }

            $sum += $video['_source']['dislike'];

            $chanels[$chanel] = $sum;
        }

        return $chanels;
    }

    private function range(array $data, int $count): array
    {
        arsort($data);

        $i = 1;

        foreach ($data as $key => $chanel) {
            if ($i > $count) {
                unset($data[$key]);
            }

            $i++;
        }

        return $data;
    }
}
