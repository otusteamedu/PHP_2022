<?php

declare(strict_types=1);

namespace Dkozlov\Otus\Command;

use Dkozlov\Otus\Exception\ConnectionTimeoutException;
use Dkozlov\Otus\Repository\Interface\EventRepositoryInterface;

class ClearEventCommand extends AbstractCommand
{
    public function __construct(
        private readonly EventRepositoryInterface $repository,
        array $args
    ) {
        parent::__construct($args);
    }

    public function execute(): void
    {
        try {
            $this->repository->clearEvents();

            echo 'Events have been successfully cleaned up' . PHP_EOL;
        } catch (ConnectionTimeoutException $e) {
            echo $e->getMessage() . PHP_EOL;
        }
    }
}