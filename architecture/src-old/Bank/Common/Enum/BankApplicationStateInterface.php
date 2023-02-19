<?php

namespace App\Bank\Common\Enum;

/**
 * Статус сделки на стороне банка.
 * Отличается от DealState (статусы для NewLk) тем, что у банков есть свои специфичные статусы, которые мы не отправим
 * в NewLk, но которые нам нужно как-то обработать, например, отправить уведомление в Telegram
 */
interface BankApplicationStateInterface
{
    public function getStateName(): string;
    public function getStateValue(): string;
}
