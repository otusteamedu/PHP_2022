<?php

declare(strict_types=1);

namespace Dkozlov\Otus\Application\Repository\Interface;

use Dkozlov\Otus\Application\QueryBuilder\Exception\EmptySearchQueryException;
use Dkozlov\Otus\Application\QueryBuilder\SearchQueryBuilder;
use Dkozlov\Otus\Application\Repository\Exception\RepositoryException;
use Dkozlov\Otus\Domain\Book;
use Dkozlov\Otus\Exception\FileNotFoundException;

interface RepositoryInterface
{
    /**
     * @throws RepositoryException
     * @throws FileNotFoundException
     */
    public function load(string $path): void;

    /**
     * @return Book[]
     * @throws RepositoryException
     * @throws EmptySearchQueryException
     */
    public function search(SearchQueryBuilder $queryBuilder): array;
}