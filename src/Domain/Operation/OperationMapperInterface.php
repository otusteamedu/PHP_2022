<?php

declare(strict_types=1);

namespace DKozlov\Otus\Domain\Operation;

use DKozlov\Otus\Exception\ConnectionTimeoutException;
use DKozlov\Otus\Exception\EntityNotFoundException;
use Exception;

interface OperationMapperInterface
{
    /**
     * @throws ConnectionTimeoutException
     * @throws EntityNotFoundException
     * @throws Exception
     */
    public function find(int $id): Operation;

    /**
     * @throws ConnectionTimeoutException
     */
    public function save(Operation $operation): void;

    /**
     * @throws ConnectionTimeoutException
     */
    public function update(Operation $operation): void;

    /**
     * @throws ConnectionTimeoutException
     */
    public function remove(string $id): void;

    /**
     * @throws ConnectionTimeoutException
     */
    public function getPersonOperations(string $person): array;
}