<?php

declare(strict_types=1);

namespace Otus\App\Application\AbstractFactory;

use Otus\App\Application\AbstractFactory\ProductFactoryInterface;
use Otus\App\Application\AbstractFactory\BurgerFactory;
use Otus\App\Application\AbstractFactory\SandwichFactory;
use Otus\App\Application\AbstractFactory\HotDogFactory;
use Otus\App\Domain\ProductInterface;

class ProductAbstractFactory extends AbstractFactory
{
    public function create($type): ProductFactoryInterface
    {
        switch ($type) {
            case ProductInterface::TYPE_BURGER:
                return new BurgerFactory();
            case ProductInterface::TYPE_SANDWICH:
                return new SandwichFactory();
            case ProductInterface::TYPE_HOTDOG:
                return new HotDogFactory();
        }
        throw new \InvalidArgumentException('Продукт не из меню!');

    }
}