<?php

declare(strict_types=1);

namespace App\Infrastructure\Command;

use App\App\BookShop\BookSearcher;
use App\App\BookShop\BookShopRepository;

class BookShopSearchingCommand implements CommandInterface
{
    private const FIELD_NAME_REPLACES = [
        'stock' => 'stock.stock'
    ];
    private BookShopRepository $repository;

    public static function getDescription(): string
    {
        return 'Осуществляет поиск в магазине по заданным параметрам';
    }

    public function __construct(private readonly BookSearcher $searcher)
    {
    }

    public function execute(array $arguments): void
    {
        foreach ($arguments as $argument) {
            [$field, $value] = \explode('=', \strtr($argument, ['--' => '']));
            $methodName = 'set' . \ucfirst($field);
            if (!\method_exists($this->searcher, $methodName)) {
                throw new \RuntimeException('Invalid parameter ' . $field);
            }
            $this->searcher->$methodName($value);
        }

        $response = $this->searcher->search();

        printf("Total docs: %d\n", $response['hits']['total']['value']);
        printf("Max score : %.4f\n", $response['hits']['max_score']);
        printf("Took      : %d ms\n\n", $response['took']);

        foreach ($response['hits']['hits'] as $item) {
            printf("Title:    %s\n", $item['_source']['title']);
            printf("Category: %s\n", $item['_source']['category']);
            printf("Price:    %d\n\n", $item['_source']['price']);
        }
    }
}