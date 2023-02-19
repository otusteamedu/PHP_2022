<?php

namespace Otus\Task13\Product\Application\Contract;

use Otus\Task13\Core\ORM\Contract\CollectionInterface;

interface GetProductsUseCaseInterface
{
    public function getAll(): CollectionInterface;
}