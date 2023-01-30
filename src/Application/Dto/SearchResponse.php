<?php

declare(strict_types=1);

namespace Dkozlov\Otus\Application\Dto;

class SearchResponse
{
    public function __construct(
        private readonly array $items
    ) {
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }
}