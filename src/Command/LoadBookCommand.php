<?php

declare(strict_types=1);

namespace Dkozlov\Otus\Command;

use Dkozlov\Otus\Exception\FileNotFoundException;
use Dkozlov\Otus\Repository\BookRepository;
use Throwable;

class LoadBookCommand extends AbstractCommand
{
    public function __construct(
        private readonly BookRepository $bookRepository,
        array $args
    ) {
        parent::__construct($args);
    }

    public function execute(): void
    {
        try {
            $this->bookRepository->load($this->args['path']);

            $response = 'Books has been loaded';
        } catch (FileNotFoundException $exception) {
            $response = $exception->getMessage();
        } catch (Throwable) {
            $response = 'While loading books happened error';
        }

        echo $response . PHP_EOL;
    }
}