<?php

declare(strict_types=1);

namespace App\Provider\Elastic\Command\Index;

use JsonException;

class CreateIndexCommand
{
    public function __construct(
        private string $index,
        private string $query
    )
    {
    }

    /**
     * @throws JsonException
     */
    public function buildParams(): array
    {
        return [
            'index' => $this->index,
            'body' => json_decode($this->query, false, 512, JSON_THROW_ON_ERROR)
        ];
    }
}
