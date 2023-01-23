<?php

declare(strict_types=1);

namespace Dkozlov\Otus\Repository\Dto;

class GetEventRequest
{
    public function __construct(
        private readonly array $params
    ) {
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }
}