<?php

declare(strict_types=1);

namespace Dkozlov\Otus\Application\Mapper;

use Dkozlov\Otus\Domain\Operation;

class OperationIdentityMap
{
    private array $mapping = [];

    public function add(string|int $key, Operation $operation): void
    {
        $this->mapping[$key] = $operation;
    }

    public function exist(string|int $key): bool
    {
        return isset($this->mapping[$key]);
    }

    public function get(string|int $key): Operation
    {
        return $this->mapping[$key];
    }

    public function remove(string|int $key): void
    {
        unset($this->mapping[$key]);
    }
}