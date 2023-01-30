<?php

declare(strict_types=1);

namespace Dkozlov\Otus\Application\Repository;

use Dkozlov\Otus\Application\QueryBuilder\Exception\EmptySearchQueryException;
use Dkozlov\Otus\Application\QueryBuilder\SearchQueryBuilder;
use Dkozlov\Otus\Application\Repository\Exception\RepositoryException;
use Dkozlov\Otus\Application\Repository\Interface\RepositoryInterface;
use Dkozlov\Otus\Application\Storage\StorageException;
use Dkozlov\Otus\Application\Storage\StorageInterface;
use Dkozlov\Otus\Domain\Book;

class BookRepository implements RepositoryInterface
{
    public function __construct(
        private readonly StorageInterface $storage
    ) {
    }

    public function load(string $path): void
    {
        try {
            $this->storage->loadJSON($path);
        } catch (StorageException $exception) {
            throw new RepositoryException($exception->getMessage());
        }
    }

    public function search(SearchQueryBuilder $queryBuilder): array
    {
        if ($queryBuilder->isEmpty()) {
            throw new EmptySearchQueryException('Search params are not set');
        }

        try {
            $response = $this->storage->search($queryBuilder);
        } catch (StorageException $exception) {
            throw new RepositoryException($exception->getMessage());
        }

        $result = [];

        foreach ($response->getItems() as $item) {
            if (empty($item['stock'])) {
                $inStock = false;
            } else {
                $inStock = max(array_column($item['stock'], 'stock')) > 0;
            }

            $result[] = new Book($item['sku'], $item['title'], (float) $item['price'], $inStock);
        }

        return $result;
    }
}