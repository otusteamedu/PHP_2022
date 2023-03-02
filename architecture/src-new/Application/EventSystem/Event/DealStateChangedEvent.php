<?php

declare(strict_types=1);

namespace App\Application\EventSystem\Event;

use App\Domain\Entity\Deal;
use new\Domain\Enum\Bank\Common\Enum\BankApplicationStateInterface;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Изменение статуса сделки
 */
class DealStateChangedEvent extends Event
{
    /**
     * @param string[] $additionalNotificationMessages Дополнительная информация, которая будет отображена в оповещении
     */
    public function __construct(
        private Deal $deal,
        private BankApplicationStateInterface $bankApplicationState,
        private string $comment = '',
        private array $additionalNotificationMessages = []
    ) {
    }

    public function getDeal(): Deal
    {
        return $this->deal;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getBankApplicationState(): BankApplicationStateInterface
    {
        return $this->bankApplicationState;
    }

    /**
     * @return string[]
     */
    public function getAdditionalNotificationMessages(): array
    {
        return $this->additionalNotificationMessages;
    }
}
