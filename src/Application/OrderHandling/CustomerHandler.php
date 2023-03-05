<?php

declare(strict_types=1);

namespace App\Application\OrderHandling;

use App\Application\UseCase\OrderStatusManagerInterface;
use App\Domain\Entity\Order;
use App\Domain\Enum\OrderStatus;

class CustomerHandler extends BaseHandler
{
    public function __construct(private readonly OrderStatusManagerInterface $orderStatusManager)
    {
    }

    public function handle(Order $order): void
    {
        if (\random_int(1, 10) < 2) {
            print_r('Покупатель нашел таракана в тарелке' . PHP_EOL);
            $this->orderStatusManager->changeStatus($order, OrderStatus::SOMETHING_WENT_WRONG);
            throw new \RuntimeException('Не удалось завершить заказ');
        }
        print_r('Покупатель принял заказ' . PHP_EOL);
        $this->orderStatusManager->changeStatus($order, OrderStatus::ACCEPTED_BY_CUSTOMER);
        $this->nextHandler->handle($order);
    }
}