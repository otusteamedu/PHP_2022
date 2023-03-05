<?php

declare(strict_types=1);

namespace App\Infrastructure\Command\BurgerQueen;

use App\Application\UseCase\AdditionDecoratorResolver;
use App\Application\UseCase\ProductCreatorResolver;
use App\Domain\Entity\Product\ProductInterface;
use App\Domain\UseCase\ProductCreatorInterface;
use App\Infrastructure\Command\CommandInterface;

class MakeOrder implements CommandInterface
{
    private const ALLOWED_OPTIONS = [
        'product',
        'additions'
    ];
    public static function getDescription(): string
    {
        return 'Сделать заказ в Burger Queen';
    }

    //  bin/console order:make --product=burger --additions=mayonnaise,lettuce,ketchup
    public function execute(array $arguments): void
    {
        $options = [];
        foreach ($arguments as $argument) {
            [$optionName, $optionValue] = \explode('=', \strtr($argument, ['--' => '']));
            if (!\in_array($optionName, self::ALLOWED_OPTIONS)) {
                throw new \RuntimeException(\sprintf(
                    'Опция %s не поддерживается. Список поддерживаемых опций: %s',
                    $optionName,
                    \implode(',', self::ALLOWED_OPTIONS)
                ));
            }
            $options[$optionName] = $optionValue;
        }

        if (!isset($options['product'])) {
            throw new \RuntimeException('Опция product обязательна к заполнению');
        }

        $product = (ProductCreatorResolver::resolve($options['product']))->create();

        $additions = \explode(',', $options['additions'] ?? '');
        $product = $this->addAdditions($product, $additions);
        dd($product);
    }

    private function addAdditions(ProductInterface $product, array $additions): ProductInterface
    {
        foreach ($additions as $addition) {
            $product = AdditionDecoratorResolver::resolve($addition, $product);
        }

        return $product;
    }
}