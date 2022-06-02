<?php


namespace Decole\Hw18\Domain\Service\BaseProductFactory;


use Decole\Hw18\Domain\Entity\BaseProduct;
use Decole\Hw18\Domain\Entity\Product\ProductInterface;
use Decole\Hw18\Domain\Service\BaseProductStrategy\BaseProductPrepareFactoryInterface;
use Decole\Hw18\Domain\Service\BaseProductStrategy\BurgerProductFactory;
use Decole\Hw18\Domain\Service\BaseProductStrategy\HotDogProductFactory;
use Decole\Hw18\Domain\Service\BaseProductStrategy\SandwichProductFactory;
use Webmozart\Assert\Assert;

class BaseProductAbstractFactory
{
    private const MAP = [
        BaseProduct::BURGER => BurgerProductFactory::class,
        BaseProduct::HOTDOG => HotDogProductFactory::class,
        BaseProduct::SANDWICH => SandwichProductFactory::class
    ];

    public function prepareBaseProduct(string $product): ProductInterface
    {
        Assert::inArray($product, BaseProduct::TYPES);

        $class = self::MAP[$product];
        $factory = new $class;

        assert($factory instanceof BaseProductPrepareFactoryInterface);

        return $factory->prepare();
    }
}