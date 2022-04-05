<?php
/**
 * Description of ReindexArticleHandler.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Services\Articles\Handlers;

use App\Models\Article;
use Elastic\Elasticsearch\Client;

class ReindexArticleHandler
{

    private Client $client;

    public function __construct(
        Client $client
    ) {
        $this->client = $client;
    }

    public function handle(Article $article)
    {
        $this->client->index(array_merge($this->generateElasticSearchParams($article), [
            'body' => $article->toSearchArray(),
        ]));
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
