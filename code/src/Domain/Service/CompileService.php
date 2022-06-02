<?php
declare(strict_types=1);


namespace Decole\Hw18\Domain\Service;


use Decole\Hw18\Domain\Entity\BaseProduct;
use Decole\Hw18\Domain\Entity\Dish;
use Decole\Hw18\Domain\Entity\InnerProduct;
use Decole\Hw18\Domain\Service\BaseProductFactory\BaseProductAbstractFactory;
use Decole\Hw18\Domain\Service\Decorator\InnerProductDecorator;
use Decole\Hw18\Domain\Service\Decorator\RecipeDecorator;
use Decole\Hw18\Domain\Service\Prototype\InnerProductPrototype;
use Decole\Hw18\Domain\Service\Strategy\BurgerCookStrategy;
use Decole\Hw18\Domain\Service\Strategy\Context;
use Decole\Hw18\Domain\Service\Strategy\HotdogCookStrategy;
use Decole\Hw18\Domain\Service\Strategy\SandwichCookStrategy;
use Decole\Hw18\Domain\Service\Strategy\Strategy;

class CompileService
{
    public function __construct(private BaseProductAbstractFactory $baseProductAbstractFactory)
    {
    }

    public function prepare(array $params): Dish
    {
        $baseProduct = $params['baseProduct'];
        $recipe = $params['recipe'];
        $innerProducts = $params['inner_product'];

        // use Abstract Factory
        $baseProductConcrete = $this->baseProductAbstractFactory->prepare($baseProduct);

        // use Decorator
        $modifiedBaseProduct = (new InnerProductDecorator($innerProducts))->joinToBaseProduct($baseProductConcrete);
        $modifiedBaseProduct = (new RecipeDecorator($recipe))->joinToBaseProduct($modifiedBaseProduct);

        // use Iterator by validate innerProduct
        /** @var InnerProductPrototype $item */
        foreach ($modifiedBaseProduct->getIterator() as $item) {
            if (!in_array($item->getType(), InnerProduct::TYPES)) {
                throw new \Exception('Inner product ' . $item->getName() . ' is not normal quality');
            }

            if (!in_array($item->getAmountType(), InnerProduct::AMOUNT_TYPES)) {
                throw new \Exception('Inner product ' . $item->getName() . ' is not normal quality');
            }
        }

        // use Strategy by cook finish dish
        /** @var Strategy $strategy */
        $strategy = match ($modifiedBaseProduct->getType()) {
            BaseProduct::BURGER => new BurgerCookStrategy(),
            BaseProduct::SANDWICH => new SandwichCookStrategy(),
            BaseProduct::HOTDOG => new HotdogCookStrategy(),
        };

        return (new Context($strategy))->makeFinishDish($modifiedBaseProduct);
    }
}