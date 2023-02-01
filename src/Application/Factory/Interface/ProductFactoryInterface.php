<?php

declare(strict_types=1);

namespace DKozlov\Otus\Application\Factory\Interface;

use DKozlov\Otus\Domain\Model\Interface\ProductInterface;

interface ProductFactoryInterface
{
    public function make(): ProductInterface;
}