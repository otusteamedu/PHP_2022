<?php

namespace app\Domain\CookBuilder;

use app\Domain\Model\Product\AbstractProduct;

class CookBuilder implements CookBuilderInterface {
    private AbstractProduct $product;

    public function __construct(AbstractProduct $product) {
        $this->product = $product;
    }

    public function prepareTools(): string
    {
        return 'Готовлю посуду для приготовления '.$this->product->getName().PHP_EOL;
    }

    public function addIngredients(): string
    {
        $str = 'Добавляю ингредиенты. '.PHP_EOL;
        foreach ($this->product->getComposition()->getIngredients() as $ingredient) {
            $str .= '- '.$ingredient->getName().PHP_EOL;
        }
        return $str;
    }

    public function cook(): string
    {
        return 'Ставлю '.$this->product->getName().' в печь'.PHP_EOL;
    }
}
