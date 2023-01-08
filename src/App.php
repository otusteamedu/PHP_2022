<?php

declare(strict_types=1);

namespace Pinguk\ElasticApp;

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

    public function execute(): void
    {
        $args = $this->commandHandler->handle();
        $response = $this->elasticClient->search($args);
        $this->printResult($response);
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
