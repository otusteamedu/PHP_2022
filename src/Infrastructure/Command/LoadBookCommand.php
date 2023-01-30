<?php

declare(strict_types=1);

namespace Dkozlov\Otus\Infrastructure\Command;

use Dkozlov\Otus\Application\Repository\Exception\RepositoryException;
use Dkozlov\Otus\Application\Repository\Interface\RepositoryInterface;
use Dkozlov\Otus\Exception\FileNotFoundException;

class LoadBookCommand extends AbstractCommand
{
    public function __construct(
        private readonly RepositoryInterface $repository,
        array $args
    ) {
        parent::__construct($args);
    }

    public function execute(): void
    {
        try {
            $this->repository->load($this->args['path'] ?? '');

            $response = 'Books has been loaded';
        } catch (FileNotFoundException|RepositoryException $exception) {
            $response = $exception->getMessage();
        }

        echo $response . PHP_EOL;
    }
}