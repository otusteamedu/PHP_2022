<?php

namespace App\Provider\Elastic\Command\Index;

class CreateIndexCommand
{
    private array $params;

    public function __construct(...$params)
    {
        $this->params = $params;
    }

    public function buildParams(): array
    {
        $properties = [];
        for ($i = 1, $iMax = count($this->params) - 1; $i < $iMax; $i += 2) {
            $properties[] = [
                $this->params[$i] => [
                    'type' => $this->params[$i + 1],
                    'analyzer' => 'rebuilt_russian'
                ],
            ];
        }
        return [
            'index' => $this->params[0],
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
