<?php

declare(strict_types=1);

namespace Dkozlov\Otus\Application\Storage;

use Dkozlov\Otus\Application\Dto\SearchResponse;
use Dkozlov\Otus\Application\QueryBuilder\SearchQueryBuilder;
use Dkozlov\Otus\Exception\FileNotFoundException;

interface StorageInterface
{
    /**
     * @throws StorageException
     * @throws FileNotFoundException
     */
    public function loadJSON(string $path): void;

    /**
     * @throws StorageException
     */
    public function search(SearchQueryBuilder $queryBuilder): SearchResponse;
}