<?php

declare(strict_types=1);

namespace App\Infrastructure\Command\BurgerQueen;

use App\Application\OrderHandling\CustomerHandler;
use App\Application\OrderHandling\KitchenHandler;
use App\Application\OrderHandling\RegisterHandler;
use App\Application\OrderHandling\WaiterHandler;
use App\Application\UseCase\AdditionDecoratorResolver;
use App\Application\UseCase\OrderStatusManager;
use App\Application\UseCase\OrderStatusManagerInterface;
use App\Application\UseCase\ProductCreatorResolver;
use App\Domain\Entity\Order;
use App\Domain\Entity\Product\ProductInterface;
use App\Infrastructure\Command\CommandInterface;

class MakeOrder implements CommandInterface
{
    public function __construct(private readonly OrderStatusManagerInterface $orderStatusManager)
    {
    }

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

        $order = new Order([$product]);
        $this->handlerOrder($order);

        $order->show();
    }

    private function addAdditions(ProductInterface $product, array $additions): ProductInterface
    {
        foreach ($additions as $addition) {
            $product = AdditionDecoratorResolver::resolve($addition, $product);
        }

        return $product;
    }

    private function handlerOrder(Order $order): void
    {
        $customerHandler = new CustomerHandler($this->orderStatusManager);
        $customerHandler->setNext();

        $waiterHandler = new WaiterHandler($this->orderStatusManager);
        $waiterHandler->setNext($customerHandler);

        $kitchenHandler = new KitchenHandler($this->orderStatusManager);
        $kitchenHandler->setNext($waiterHandler);

        $registerHandler = new RegisterHandler($this->orderStatusManager);
        $registerHandler->setNext($kitchenHandler);

        $registerHandler->handle($order);
    }
}