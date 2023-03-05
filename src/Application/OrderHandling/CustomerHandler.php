<?php

declare(strict_types=1);

namespace App\Application\OrderHandling;

use App\Domain\Entity\Order;
use App\Domain\Enum\OrderStatus;

class CustomerHandler extends BaseHandler
{
    public function handle(Order $order): void
    {
        if (\random_int(1, 10) < 2) {
            print_r('Покупатель нашел таракана в тарелке' . PHP_EOL);
            $order->changeStatus(OrderStatus::SOMETHING_WENT_WRONG);
            throw new \RuntimeException('Не удалось завершить заказ');
        }
        print_r('Покупатель принял заказ' . PHP_EOL);
        $order->changeStatus(OrderStatus::ACCEPTED_BY_CUSTOMER);
        $this->nextHandler->handle($order);
    }
}