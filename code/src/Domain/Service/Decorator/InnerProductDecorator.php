<?php
declare(strict_types=1);


namespace Decole\Hw18\Domain\Service\Decorator;


use Decole\Hw18\Domain\Entity\Product\ProductInterface;
use Decole\Hw18\Domain\Service\Prototype\InnerProductPrototype;

class InnerProductDecorator implements ComponentInterface
{
    private ?array $innerProducts;

    public function __construct($component)
    {
        $this->innerProducts = $component;
    }

    public function joinToBaseProduct(ProductInterface $baseProduct): ProductInterface
    {
        foreach ($this->innerProducts as $concreteInnerProduct) {
            $innerProductsParam = explode('::', $concreteInnerProduct);
            $prototype = new InnerProductPrototype();
            $prototype->name = $innerProductsParam[0];
            $prototype->type = $innerProductsParam[1];
            $prototype->amountType = $innerProductsParam[2];
            $prototype->amount = $innerProductsParam[3];

            $baseProduct->join(clone $prototype);
        }

        return $baseProduct;
    }
}