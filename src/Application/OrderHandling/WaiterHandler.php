<?php

declare(strict_types=1);

namespace App\Application\OrderHandling;

use App\Application\EventSystem\ChangeOrderStatusEvent;
use App\Application\EventSystem\DispatcherInterface;
use App\Application\UseCase\OrderStatusManagerInterface;
use App\Domain\Entity\Order;
use App\Domain\Enum\OrderStatus;

class WaiterHandler extends BaseHandler
{
    public function __construct(private readonly DispatcherInterface $dispatcher)
    {
    }

    public function handle(Order $order): void
    {
        $this->dispatcher->dispatch(new ChangeOrderStatusEvent($order, OrderStatus::DELIVERING_TO_CUSTOMER));
        if (\random_int(1, 10) < 2) {
            $this->dispatcher->dispatch(new ChangeOrderStatusEvent(
                $order,
                OrderStatus::SOMETHING_WENT_WRONG,
                'Официант выронил заказ'
            ));
            throw new \RuntimeException('Не удалось завершить заказ');
        }

        $this->dispatcher->dispatch(new ChangeOrderStatusEvent($order, OrderStatus::DELIVERED_TO_CUSTOMER));
        $this->nextHandler->handle($order);
    }
}