<?php

declare(strict_types=1);

namespace Dkozlov\Otus\Application\Interface;

use Dkozlov\Otus\Domain\Operation;
use Dkozlov\Otus\Exception\ConnectionTimeoutException;
use Dkozlov\Otus\Exception\EntityNotFoundException;
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