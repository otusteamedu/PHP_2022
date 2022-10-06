<?php

namespace Nikolai\Php\ElasticSearchClient;

use Elasticsearch\Namespaces\IndicesNamespace;

interface ElasticSearchClientInterface
{
    const INDEX_NAME = 'otus-shop';

    const INDEX_MAPPINGS_PROPERTIES = [
        "title" => ["type" => "text"],
        "sku" => ["type" => "text"],
        "category" => ["type" => "keyword"],
        "price" => ["type" => "short"],
        "stock" => [
            "type" => "nested",
            "properties" => [
                "shop" => ["type" => "keyword"],
                "stock" => ["type" => "short"]
            ]
        ]
    ];

    public function create(array $params = []): array;
    public function bulk(array $params = []): array;
    public function delete(array $params = []): array;
    public function get(array $params = []): array;
    public function index(array $params = []): array;
    public function info(array $params = []): array;
    public function reindex(array $params = []): array;
    public function search(array $params = []): array;
    public function update(array $params = []): array;
    public function indices(): IndicesNamespace;
}