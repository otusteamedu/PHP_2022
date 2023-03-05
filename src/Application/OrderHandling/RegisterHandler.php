<?php

declare(strict_types=1);

namespace App\Application\OrderHandling;

use App\Domain\Entity\Order;
use App\Domain\Enum\OrderStatus;

class RegisterHandler extends BaseHandler
{
    public function handle(Order $order): void
    {
        print_r('Заказ оформлен' . PHP_EOL);
        if (\random_int(1, 10) < 2) {
            print_r('Недостаточно денег на карте' . PHP_EOL);
            $order->changeStatus(OrderStatus::SOMETHING_WENT_WRONG);
            throw new \RuntimeException('Не удалось завершить заказ');
        }
        print_r('Заказ оплачен' . PHP_EOL);
        print_r('Выдан кассовый чек' . PHP_EOL);
        $order->changeStatus(OrderStatus::ACCEPTED);
        $this->nextHandler->handle($order);
    }
}