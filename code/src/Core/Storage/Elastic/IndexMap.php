<?php

declare(strict_types=1);

namespace Kogarkov\Es\Core\Storage\Elastic;

class IndexMap
{
    private $index_map_list = [
        'otus-shop' => [
            'settings' => [
                'analysis' => [
                    'analyzer' => [
                        'russian' => [
                            'type' => 'custom',
                            'tokenizer' => 'standard',
                            'filter' => ['lowercase']
                        ]
                    ]
                ]
            ],
            'mappings' => [
                '_source' => [
                    'enabled' => true
                ],
                'properties' => [
                    'title' => [
                        'type' => 'text'
                    ],
                    'sku' => [
                        'type' => 'text'
                    ],
                    'category' => [
                        'type' => 'keyword'
                    ],
                    'price' => [
                        'type' => 'short'
                    ],
                    'stock' => [
                        'type' => 'nested',
                        'properties' => [
                            'shop' => [
                                'type' => 'keyword'
                            ],
                            'stock' => [
                                'type' => 'short'
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ];

    public function getIndex(string $index_name): array
    {
        if (array_key_exists($index_name, $this->index_map_list)) {
            return $this->index_map_list[$index_name];
        } else {
            throw new \Exception("No map for index $index_name");
        }
    }

    public function getIndexFields(string $index_name): array
    {
        if (array_key_exists($index_name, $this->index_map_list)) {
            return array_keys($this->index_map_list[$index_name]['mappings']['properties']);
        } else {
            throw new \Exception("No map for index $index_name");
        }
    }
}
