<?php
declare(strict_types=1);


namespace Decole\Hw18\Domain\Service\Strategy;


use Decole\Hw18\Domain\Entity\Dish;
use Decole\Hw18\Domain\Entity\DishWrapper;
use Decole\Hw18\Domain\Entity\InnerProduct;
use Decole\Hw18\Domain\Entity\Product\ProductInterface;
use Decole\Hw18\Domain\Service\Prototype\InnerProductPrototype;

class BurgerCookStrategy implements Strategy
{
    public function cook(ProductInterface $baseProduct): Dish
    {
        $dish = new Dish();
        $dish->setBaseProduct($baseProduct);

        /** @var InnerProductPrototype $prototypeInnerProduct */
        foreach ($baseProduct->getInnerPrototypeProducts() as $prototypeInnerProduct) {
            $innerProduct = new InnerProduct(
                name: $prototypeInnerProduct->getName(),
                type: $prototypeInnerProduct->getType(),
                amountType: $prototypeInnerProduct->getAmountType(),
                amount: $prototypeInnerProduct->getAmount()
            );

            $dish->setInnerProduct($innerProduct);
        }

        $dish->setWrapper(new DishWrapper('Тарелка'));

        return $dish;
    }
}