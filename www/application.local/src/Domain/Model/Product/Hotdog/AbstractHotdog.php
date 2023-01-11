<?php

declare(strict_types=1);

namespace app\Domain\Model\Product\Hotdog;

use app\Domain\Model\Ingredient\Bun;
use app\Domain\Model\Ingredient\Sausage;
use app\Domain\Model\Product\AbstractProduct;

abstract class AbstractHotdog extends AbstractProduct {
    public function __construct() {
        parent::__construct();
        $this->addIngredient(new Bun());
        $this->addIngredient(new Sausage());
    }
}
