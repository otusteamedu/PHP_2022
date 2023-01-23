<?php

declare(strict_types=1);

namespace Dkozlov\Otus\Repository\Interface;

use Dkozlov\Otus\Exception\EmptySearchQueryException;
use Dkozlov\Otus\Exception\FileNotFoundException;
use Dkozlov\Otus\Exception\RepositoryException;
use Dkozlov\Otus\QueryBuilder\SearchQueryBuilder;

interface RepositoryInterface
{
    /**
     * @throws FileNotFoundException
     * @throws RepositoryException
     */
    public function load(string $path): void;

    /**
     * @throws EmptySearchQueryException
     * @throws RepositoryException
     */
    public function search(SearchQueryBuilder $queryBuilder): array;
}