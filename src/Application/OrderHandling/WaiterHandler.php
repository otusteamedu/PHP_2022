<?php

declare(strict_types=1);

namespace App\Application\OrderHandling;

use App\Domain\Entity\Order;
use App\Domain\Enum\OrderStatus;

class WaiterHandler extends BaseHandler
{
    public function handle(Order $order): void
    {
        print_r('Официант забрал заказ' . PHP_EOL);
        $order->changeStatus(OrderStatus::DELIVERING_TO_CUSTOMER);
        if (\random_int(1, 10) < 2) {
            print_r('Официант выронил заказ' . PHP_EOL);
            $order->changeStatus(OrderStatus::SOMETHING_WENT_WRONG);
            throw new \RuntimeException('Не удалось завершить заказ');
        }
        print_r('Официант принес заказ покупателю' . PHP_EOL);
        $this->nextHandler->handle($order);
    }
}