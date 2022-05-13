<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\YoutubeStatistics;
use Doctrine\Common\Collections\ArrayCollection;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Response\ElasticsearchInterface;

/**
 * ElasticsearchYoutubeStatisticsRepository
 */
class ElasticsearchYoutubeStatisticsRepository
{
    /**
     * @var Client
     */
    private Client $elasticsearch;

    /**
     * @var YoutubeStatistics
     */
    private $entity;

    /**
     * @throws \Elastic\Elasticsearch\Exception\AuthenticationException
     */
    public function __construct()
    {
        $this->elasticsearch = ClientBuilder::create()
            ->setHosts(["{$_ENV['ES_HOST']}:{$_ENV['ES_PORT']}"])
            ->build();

        $this->entity = new YoutubeStatistics();
    }

    /**
     * @param array $m
     * @param int $limit
     * @param int $offset
     * @return ArrayCollection
     */
    public function search(array $m, int $limit, int $offset = 0): ArrayCollection
    {
        $items = $this->searchOnElasticsearchMatch($m, $limit, $offset);

        return $this->buildCollectionAggr($items);
    }


    /**
     * @param array $paramMatch
     * @param int $limit
     * @param int $offset
     * @return ElasticsearchInterface
     * @throws \Elastic\Elasticsearch\Exception\ClientResponseException
     * @throws \Elastic\Elasticsearch\Exception\MissingParameterException
     * @throws \Elastic\Elasticsearch\Exception\ServerResponseException
     */
    private function searchOnElasticsearchMatch(array $paramMatch, int $limit, int $offset): ElasticsearchInterface
    {
        $paramMatch = array_map(static function($k, $v) {

            return [ 'match' => [ $k => $v ] ];

        }, array_keys($paramMatch), $paramMatch);

        $params = [
            'index' => $this->entity->getSearchIndex(),
            'type' => $this->entity->getSearchType(),
            'body'  => [
                'query' => [
                    'bool' => [
                        'must' => $paramMatch
                    ]
                ],
                'aggs' => [
                    "like_total_sum" => [
                        "sum" => [
                            "field" => "like"
                        ]
                    ],
                    "dislike_total_sum" => [
                        "sum" => [
                            "field" => "dislike"
                        ]
                    ],
                    "like_top" => [
                        "max" => [
                            "field" => "like"
                        ]
                    ],
                    "dislike_top" => [
                        "max" => [
                            "field" => "dislike"
                        ]
                    ],
                ],
            ],
            'size' => $limit,
            'from' => $offset,
        ];

        return $this->elasticsearch->search($params);
    }

    /**
     * @param ElasticsearchInterface $items
     * @return ArrayCollection
     */
    private function buildCollectionAggr(ElasticsearchInterface $items): ArrayCollection
    {
        $aggregations = $items['aggregations'];

        return new ArrayCollection($aggregations);
    }
}