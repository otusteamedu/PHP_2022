<?php

namespace app\Application\Service;

use app\Application\Dto\CreateOrderRequestDTO;
use app\Domain\Model\Order\AbstractOrder;

interface OrderServiceInterface {
    public function createOrder(CreateOrderRequestDTO $request): AbstractOrder;
    public function cookOrder(AbstractOrder $order): string;
}
