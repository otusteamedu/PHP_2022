<?php

declare(strict_types=1);

namespace app\Domain\Model\Product\Sandwich;

use app\Domain\Model\Ingredient\Bread;
use app\Domain\Model\Ingredient\Sausage;
use app\Domain\Model\Product\AbstractProduct;

abstract class AbstractSandwich extends AbstractProduct {
    public function __construct() {
        parent::__construct();
        $this->addIngredient(new Bread());
        $this->addIngredient(new Sausage());
    }
}
