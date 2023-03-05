<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Domain\Entity\Additions\CheeseDecorator;
use App\Domain\Entity\Additions\KetchupDecorator;
use App\Domain\Entity\Additions\LettuceDecorator;
use App\Domain\Entity\Additions\MayonnaiseDecorator;
use App\Domain\Entity\Product\ProductInterface;

class AdditionDecoratorResolver
{
    /**
     * @var array<class-string<ProductInterface>>
     */
    private const ADDITION_NAME_TO_DECORATOR_MAPPING = [
        'cheese' => CheeseDecorator::class,
        'ketchup' => KetchupDecorator::class,
        'lettuce' => LettuceDecorator::class,
        'mayonnaise' => MayonnaiseDecorator::class,
    ];

    public static function resolve(string $additionName, ProductInterface $product): ProductInterface
    {
        $decoratorClass = self::ADDITION_NAME_TO_DECORATOR_MAPPING[$additionName] ?? null;
        if (\is_null($decoratorClass)) {
            throw new \RuntimeException(\sprintf(
                'Тип добавки %s не поддерживается',
                $additionName
            ));
        }

        return new $decoratorClass($product);
    }
}