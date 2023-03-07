<?php

declare(strict_types=1);

namespace App\Application\OrderHandling;

use App\Application\EventSystem\ChangeOrderStatusEvent;
use App\Application\EventSystem\DispatcherInterface;
use App\Application\UseCase\OrderStatusManagerInterface;
use App\Domain\Entity\Order;
use App\Domain\Enum\OrderStatus;

class CustomerHandler extends BaseHandler
{
    public function __construct(private readonly DispatcherInterface $dispatcher)
    {
    }

    public function handle(Order $order): void
    {
        if (\random_int(1, 10) < 2) {
            $this->dispatcher->dispatch(new ChangeOrderStatusEvent(
                $order,
                OrderStatus::SOMETHING_WENT_WRONG,
                'Покупатель нашел таракана в тарелке'
            ));
            throw new \RuntimeException('Не удалось завершить заказ');
        }

        $this->dispatcher->dispatch(new ChangeOrderStatusEvent($order, OrderStatus::ACCEPTED_BY_CUSTOMER));
        $this->nextHandler->handle($order);
    }
}