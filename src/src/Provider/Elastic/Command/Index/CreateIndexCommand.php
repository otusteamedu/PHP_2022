<?php

namespace App\Provider\Elastic\Command\Index;

use Elastic\Elasticsearch\Client;
use Exception;

class CreateIndexCommand
{
    /**
     * @throws Exception
     */
    public function __construct(private array $params, private Client $client)
    {
    }

    /**
     * @return string
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    public function buildParams(): array
    {
        $params = $this->getParams();
        $properties = [];
        foreach ($params['properties'] as $property) {
            $properties[] = [
                $property['name'] => [
                    'type' => $property['type'],
                    'analyzer' => 'rebuilt_russian'
                ],
            ];
        }
        return [
            'index' => $params['index'],
            'settings' => [
                "analysis" => [
                    "filter" => [
                        "russian_stop" => [
                            "type" => "stop",
                            "stopwords" => "_russian_"
                        ],
                        "russian_stemmer" => [
                            "type" => "stemmer",
                            "language" => "russian"
                        ]
                    ],
                    "analyzer" => [
                        "rebuilt_russian" => [
                            "tokenizer" => "standard",
                            "filter" => [
                                "lowercase",
                                "russian_stop",
                                "russian_stemmer"
                            ]
                        ]
                    ]
                ]
            ],
            'mappings' => [
                'properties' => $properties
            ]
        ];
    }
}
