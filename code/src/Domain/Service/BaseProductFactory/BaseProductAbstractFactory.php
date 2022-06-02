<?php
declare(strict_types=1);


namespace Decole\Hw18\Domain\Service\BaseProductFactory;


use Decole\Hw18\Domain\Entity\BaseProduct;
use Decole\Hw18\Domain\Entity\Product\ProductInterface;
use Webmozart\Assert\Assert;

class BaseProductAbstractFactory
{
    private const MAP = [
        BaseProduct::BURGER => BurgerProductFactory::class,
        BaseProduct::HOTDOG => HotDogProductFactory::class,
        BaseProduct::SANDWICH => SandwichProductFactory::class
    ];

    public function prepare(string $product): ProductInterface
    {
        Assert::inArray($product, BaseProduct::TYPES);

        $class = self::MAP[$product];
        $factory = new $class;

        assert($factory instanceof BaseProductPrepareFactoryInterface);

        return $factory->prepare();
    }
}