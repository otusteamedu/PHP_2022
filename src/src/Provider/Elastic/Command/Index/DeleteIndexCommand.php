<?php

declare(strict_types=1);

namespace App\Provider\Elastic\Command\Index;

class DeleteIndexCommand
{
    public function __construct(private string $index)
    {
    }

    public function buildParams(): array
    {
        return [
            'index' => $this->index,
        ];
    }
}
