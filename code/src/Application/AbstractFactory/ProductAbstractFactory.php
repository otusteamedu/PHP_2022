<?php

declare(strict_types=1);

namespace Otus\App\Application\AbstractFactory;

use Otus\App\Application\AbstractFactory\ProductFactoryInterface;
use Otus\App\Application\AbstractFactory\BurgerFactory;
use Otus\App\Application\AbstractFactory\SandwichFactory;
use Otus\App\Application\AbstractFactory\HotDogFactory;
use Otus\App\Domain\ProductInterface;

class ProductAbstractFactory
{
    public function create($type) : ProductFactoryInterface
    {
        if ($type == ProductInterface::TYPE_BURGER) {
            return new BurgerFactory();
        } else if ($type == ProductInterface::TYPE_SANDWICH) {
            return new SandwichFactory();
        } else if ($type == ProductInterface::TYPE_HOTDOG) {
            return new HotDogFactory();
        } else
            throw new \InvalidArgumentException('Wrong product type!');
    }
}