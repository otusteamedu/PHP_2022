<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\ElasticsearchYoutubeStatisticsRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * ElasticSearch
 */
class ElasticSearch
{

    /**
     * @return JsonResponse
     */
    public static function search(): JsonResponse
    {
        $response = new JsonResponse();
        $esRepository = new ElasticsearchYoutubeStatisticsRepository();
        $result = $esRepository->search([],1);
        return $response->setData($result->toArray());
    }
}