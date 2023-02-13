<?php

namespace src\App\Gateway\Payment;

interface PaymentSystemGatewayInterface
{
    /**
     * Тут на вход должны передаваться какие-то данные карты и в ответ тоже что-то должно быть, но для тестов пока и так
     * подойдет
     */
    public function charge(): bool;
}