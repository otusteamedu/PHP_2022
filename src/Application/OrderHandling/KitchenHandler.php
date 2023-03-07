<?php

declare(strict_types=1);

namespace App\Application\OrderHandling;

use App\Application\EventSystem\ChangeOrderStatusEvent;
use App\Application\EventSystem\DispatcherInterface;
use App\Domain\Entity\Order;
use App\Domain\Enum\OrderStatus;

class KitchenHandler extends BaseHandler
{
    public function __construct(private readonly DispatcherInterface $dispatcher)
    {
    }

    public function handle(Order $order): void
    {
        $this->dispatcher->dispatch(new ChangeOrderStatusEvent(
            $order,
            OrderStatus::COOKING,
            'Заказ принят на кухне'
        ));

        if (\random_int(1, 10) < 2) {
            $this->dispatcher->dispatch(new ChangeOrderStatusEvent(
                $order,
                OrderStatus::SOMETHING_WENT_WRONG,
                'Не хватает ингредиентов'
            ));
            throw new \RuntimeException('Не удалось завершить заказ');
        }

        $this->dispatcher->dispatch(new ChangeOrderStatusEvent(
            $order,
            OrderStatus::WAITING_FOR_WAITER,
            'Заказ готов к выдаче'
        ));
        $this->nextHandler->handle($order);
    }
}