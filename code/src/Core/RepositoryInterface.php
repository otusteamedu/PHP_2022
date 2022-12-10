<?php

declare(strict_types=1);

namespace Otus\App\Core;

interface RepositoryInterface
{
    public function search(array $params): array;
}
