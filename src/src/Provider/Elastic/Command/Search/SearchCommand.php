<?php

namespace App\Provider\Elastic\Command\Search;

class SearchCommand
{
    public function __construct(
        private string $index,
        private string $field,
        private string $query
    )
    {
    }

    public function buildParams(): array
    {
        return [
            'index' => $this->index,
            'body' => [
                'query' => [
                    'match' => [
                        $this->field => [
                            'query' => $this->query,
                            'fuzziness' => 'auto'
                        ]
                    ],
                ]
            ]
        ];
    }
}