<?php

declare(strict_types=1);

namespace Nemizar\OtusShop\clients;

use Nemizar\OtusShop\entity\Book;

interface RepositoryInterface
{
    /**
     * @param Book[] $params
     * @return array
     */
    public function search(array $params): array;
}
