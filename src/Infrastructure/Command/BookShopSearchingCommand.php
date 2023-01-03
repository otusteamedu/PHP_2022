<?php

declare(strict_types=1);

namespace App\Infrastructure\Command;

use App\App\Service\BookShopRepository;

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

    public function __construct(BookShopRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(array $arguments): void
    {
        $conditions = [];

        foreach ($arguments as $argument) {
            [$field, $value] = \explode('=', \strtr($argument, ['--' => '']));
            if (isset(self::FIELD_NAME_REPLACES[$field])) {
                $field = self::FIELD_NAME_REPLACES[$field];
            }
            if (\str_contains($value, '_')) {
                [$comparableIdentifier, $comparableValue] = \explode('_', $value);
                $conditions[] = [
                    'range' => [
                        $field => [
                            $comparableIdentifier => $comparableValue
                        ]
                    ]
                ];
            } else {
                $conditions[] = [
                    'match' => [
                        $field => [
                            'query' => $value,
                            'fuzziness' => 'auto',
                        ]
                    ]
                ];
            }
        }

        $query = [
            'bool' => [
                'must' => $conditions
            ]
        ];

        $response = $this->repository->search($query);

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