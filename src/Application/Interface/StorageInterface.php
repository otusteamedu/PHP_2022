<?php

declare(strict_types=1);

namespace Dkozlov\Otus\Application\Interface;

use Dkozlov\Otus\Exception\ConnectionTimeoutException;

interface StorageInterface
{
    /**
     * @throws ConnectionTimeoutException
     */
    public function select(string $query, array $params): array;

    /**
     * @throws ConnectionTimeoutException
     */
    public function insert(string $query, array $params): void;

    /**
     * @throws ConnectionTimeoutException
     */
    public function update(string $query, array $params): void;

    /**
     * @throws ConnectionTimeoutException
     */
    public function delete(string $query, array $params): void;
}