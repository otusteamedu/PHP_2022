<?php

declare(strict_types=1);

namespace Pinguk\ElasticApp;

use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Pinguk\ElasticApp\Service\Elastic;
use Pinguk\ElasticApp\Utils\InputCommandHandler;

class App
{
    private Elastic $elasticClient;
    private InputCommandHandler $commandHandler;

    public function __construct()
    {
        $this->elasticClient = new Elastic();
        $this->commandHandler = new InputCommandHandler();
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function execute(): void
    {
        $query = $this->prepareQuery();
        $response = $this->elasticClient->search($query);
        $this->printResult($response);
    }

    private function prepareQuery(): array
    {
        $criteria = $this->commandHandler->handle();
        $condition = [
            'filter' => [],
            'must' => []
        ];

        if (isset($criteria['priceGt'])) {
            $condition['filter'][] = ['range' => ['price' => ['gte' => $criteria['priceGt']]]];
        }

        if (isset($criteria['priceLt'])) {
            $condition['filter'][] = ['range' => ['price' => ['lte' => $criteria['priceLt']]]];
        }

        if (isset($criteria['in-stock'])) {
            $condition['filter'][] = ['range' => ['stock.stock' => ['gt' => 0]]];
        }

        if (isset($criteria['sku'])) {
            $condition['filter'][] = ['term' => ['sku' => $criteria['sku']]];
        }

        if (isset($criteria['shop'])) {
            $condition['filter'][] = ['term' => ['shop' => $criteria['shop']]];
        }

        if (isset($criteria['title'])) {
            $condition['must'][] = ['match' => ['title' => $criteria['title']]];
        }

        if (isset($criteria['category'])) {
            $condition['must'][] = ['match' => ['category' => $criteria['category']]];
        }

        return $condition;
    }

    private function printResult(array $data): void
    {
        printf("Найдено книг: %d\n", $data["hits"]["total"]["value"]);
        printf("%s\n", str_repeat("=", 15));

        foreach ($data["hits"]["hits"] as $item) {
            printf("Заголовок: %s\n", $item["_source"]["title"]);
            printf("Категория: %s\n", $item["_source"]["category"]);
            printf("Цена: %s\n", $item["_source"]["price"]);
            printf("Артикул: %s\n", $item["_source"]["sku"]);
            printf("Наличие: \n%s\n", implode("\n", array_map(static fn($stock) => "=> " . $stock['shop'] . ": " . $stock['stock'], $item["_source"]["stock"])));
            printf("%s\n", str_repeat("-", 15));
        }
    }
}
