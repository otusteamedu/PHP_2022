<?php

namespace Otus\Task14\Composite;

use Otus\Task14\Factory\Contract\ProductInterface;

class ProductDish extends Dish
{

    private ?Dish $ingredient;

    public function __construct(
        private readonly ProductInterface $product,
    ){}

    public function add(Dish $component)
    {
       $this->ingredient = $component;
    }

    public function getProduct(){
        return $this->product;
    }

    public function collectTogether(){
       echo 'Собираем блюдо "' .$this->getProduct()->getName() . '":' . PHP_EOL;
       $this->ingredient->collectTogether();
    }
}