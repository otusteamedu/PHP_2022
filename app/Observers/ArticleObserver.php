<?php

namespace App\Observers;

use App\Models\Article;
use Elasticsearch\Client;

class ArticleObserver
{
    private Client $elasticsearch;
    public function __construct(
        Client $elasticsearch
    )
    {
        $this->elasticsearch = $elasticsearch;
    }

    public function saved(Article $model)
    {
        $this->elasticsearch->index(
            array_merge($this->generateElasticSearchParams($model), [
            'body' => $model->toSearchArray(),
        ]));
    }

    public function deleted(Article $model)
    {
        $this->elasticsearch->delete(
            $this->generateElasticSearchParams($model)
        );
    }

    private function generateElasticSearchParams(Article $model): array
    {
        return [
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'id' => $model->getKey(),
        ];
    }
}
