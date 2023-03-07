<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Domain\UseCase\BurgerCreator;
use App\Domain\UseCase\HotDogCreator;
use App\Domain\UseCase\ProductCreatorInterface;
use App\Domain\UseCase\SandwichCreator;

class ProductCreatorResolver
{
    private const PRODUCT_NAME_TO_CREATOR_MAPPING = [
        'burger' => BurgerCreator::class,
        'sandwich' => SandwichCreator::class,
        'hot-dog' => HotDogCreator::class,
    ];

    public static function resolve(string $productName): ProductCreatorInterface
    {
        $creatorClass = self::PRODUCT_NAME_TO_CREATOR_MAPPING[$productName] ?? null;
        if (\is_null($creatorClass)) {
            throw new \RuntimeException(\sprintf(
                'Тип продукта %s не поддерживается',
                $productName
            ));
        }

        return new $creatorClass();
    }
}