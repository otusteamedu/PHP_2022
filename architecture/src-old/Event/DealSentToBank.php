<?php

namespace App\Event;

use App\Entity\Deal;
use Symfony\Contracts\EventDispatcher\Event;

class DealSentToBank extends Event
{
    private Deal $deal;
    /**
     * Флаг, показывающий, что сделка отправляется в банк первый раз (не доработка и не исправление ошибок)
     */
    private bool $isInitialSending;

    public function __construct(Deal $deal, bool $isInitialSending = true)
    {
        $this->deal = $deal;
        $this->isInitialSending = $isInitialSending;
    }

    public function getDeal(): Deal
    {
        return $this->deal;
    }

    public function isInitialSending(): bool
    {
        return $this->isInitialSending;
    }
}
