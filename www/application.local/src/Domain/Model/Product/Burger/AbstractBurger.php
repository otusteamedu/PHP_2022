<?php

declare(strict_types=1);

namespace app\Domain\Model\Product\Burger;

use app\Domain\Model\Ingredient\Bun;
use app\Domain\Model\Ingredient\Cutlet;
use app\Domain\Model\Product\AbstractProduct;

abstract class AbstractBurger extends AbstractProduct {
    public function __construct() {
        parent::__construct();
        $this->addIngredient(new Bun());
        $this->addIngredient(new Cutlet());
    }
}
