<?php

declare(strict_types=1);

namespace Nikolai\Php\Controller;

use Nikolai\Php\ElasticSearchClient\ElasticSearchClient;
use Nikolai\Php\ElasticSearchClient\ElasticSearchClientInterface;
use Symfony\Component\HttpFoundation\Request;

class CreateIndexController
{
    const PARAMS = [
        'index' => ElasticSearchClientInterface::INDEX_NAME,
        'body' => [
            "settings" => [
                "analysis" => [
                    "filter" => [
                        "russian_stop" => [
                            "type" => "stop",
                            "stopwords" =>  "_russian_"
                        ],
                        "russian_stemmer" => [
                            "type" => "stemmer",
                            "language" => "russian"
                        ]
                    ],
                    "analyzer" => [
                        "my_russian" => [
                            'type' => 'custom',
                            'tokenizer' => 'standard',
                            "filter" => [
                                "lowercase",
                                "russian_stop",
                                "russian_stemmer"
                            ]
                        ]
                    ]
                ]
            ],
            "mappings" => [
                'properties' => ElasticSearchClientInterface::INDEX_MAPPINGS_PROPERTIES
            ]
        ],
    ];

    public function __construct(private ElasticSearchClient $elasticSearchClient) {}

    public function __invoke(Request $request)
    {
        try {
            $response = $this->elasticSearchClient->indices()->create(self::PARAMS);
            if ($response['acknowledged'] === true && $response['index'] === ElasticSearchClientInterface::INDEX_NAME) {
                echo 'Индекс: ' . ElasticSearchClientInterface::INDEX_NAME . ' создан!' . PHP_EOL;
            } else {
                echo 'Некорректный ответ при создании индекса:';
                var_dump($response);
            }
        } catch (\Exception $exception) {
            echo 'Ошибка при создании индекса:' . PHP_EOL;
            var_dump(json_decode($exception->getMessage()));
        }
    }
}