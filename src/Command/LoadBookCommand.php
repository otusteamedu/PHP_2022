<?php

declare(strict_types=1);

namespace Dkozlov\Otus\Command;

use Dkozlov\Otus\Exception\FileNotFoundException;
use Dkozlov\Otus\Exception\RepositoryException;
use Dkozlov\Otus\Repository\Interface\RepositoryInterface;

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