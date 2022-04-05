<?php
/**
 * Description of ElasticSearchArticleRepository.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Services\Articles\Repositories;

use App\Models\Article;
use Elasticsearch\Client;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class ElasticsearchSearchSearchArticleRepository implements SearchArticleRepository
{
    private Client $elasticsearch;

    public function __construct(Client $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }


    public function search(string $q, int $limit, int $offset = 0): Collection
    {
        $items = $this->searchOnElasticsearchTitle($q, $limit, $offset);
        return $this->buildCollection($items);
    }

    private function searchOnElasticsearchTitle(string $query, int $limit, int $offset): array
    {
        $model = new Article();
        return $this->elasticsearch->search([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'body' => [
                'query' => [
                    'query_string' => [
                        'fields' => [
                            'title^5',
                            'body',
                            'tags',
                        ],
                        'query' => $query . '*',
                        "analyze_wildcard" => true,
                        "allow_leading_wildcard" => true
                    ],
                ],
            ],
            'size' => $limit,
            'from' => $offset,
        ]);
    }

    private function buildCollection(array $items): Collection
    {
        $ids = Arr::pluck($items['hits']['hits'], '_id');
        return Article::findMany($ids)
            ->sortBy(function ($article) use ($ids) {
                return array_search($article->getKey(), $ids);
            });
    }
}
