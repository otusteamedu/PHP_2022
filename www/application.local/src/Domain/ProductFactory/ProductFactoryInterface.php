<?php

declare(strict_types=1);

namespace app\Domain\ProductFactory;

use app\Domain\Model\Product\Burger\AbstractBurger;
use app\Domain\Model\Product\Hotdog\AbstractHotdog;
use app\Domain\Model\Product\Sandwich\AbstractSandwich;

interface ProductFactoryInterface {
    public function createBaseBurger(): AbstractBurger;
    public function createBaseHotdog(): AbstractHotdog;
    public function createBaseSandwich(): AbstractSandwich;
}
