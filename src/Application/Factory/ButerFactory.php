<?php

declare(strict_types=1);

namespace DKozlov\Otus\Application\Factory;

use DKozlov\Otus\Application\Factory\Interface\ProductFactoryInterface;
use DKozlov\Otus\Domain\Model\Adapter\ButerAdapter;
use DKozlov\Otus\Domain\Model\Interface\ProductInterface;

class ButerFactory implements ProductFactoryInterface
{
    public function make(): ProductInterface
    {
        return ButerAdapter::make();
    }
}