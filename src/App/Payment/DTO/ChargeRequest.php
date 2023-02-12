<?php

declare(strict_types=1);

namespace App\App\Payment\DTO;

class ChargeRequest
{
    /**
     * Номер карты, 16 цифр
     */
    public string $card_number;

    /**
     * Владелец карты, имя и фамилия латиницей, может также содержать дефис
     */
    public string $card_holder;

    /**
     * Месяц/год окончания действия карты в формате мм/гг
     */
    public string $card_expiration;

    /**
     * Код с обратной стороны карты, 3 цифры
     */
    public string $cvv;

    /**
     * Номер заказа, до 16 произвольных символов
     */
    public string $order_number;

    /**
     * Сумма оплаты, разделитель дробной и целой части запятая, поэтому и строка, а не число
     */
    public string $sum;

    public function __construct(string $card_number, string $card_holder, string $card_expiration, string $cvv, string $order_number, string $sum)
    {
        $this->card_number = $card_number;
        $this->card_holder = $card_holder;
        $this->card_expiration = $card_expiration;
        $this->cvv = $cvv;
        $this->order_number = $order_number;
        $this->sum = $sum;
    }
}