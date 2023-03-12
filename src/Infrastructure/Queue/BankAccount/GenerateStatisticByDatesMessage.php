<?php

declare(strict_types=1);

namespace App\Infrastructure\Queue\BankAccount;

use App\Application\Queue\MessageInterface;

class GenerateStatisticByDatesMessage implements MessageInterface
{
    private \DateTimeImmutable $dateStart;
    private \DateTimeImmutable $dateEnd;

    public function __construct(\DateTimeImmutable $dateStart, \DateTimeImmutable $dateEnd)
    {
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
    }

    public function getDateStart(): \DateTimeImmutable
    {
        return $this->dateStart;
    }

    public function getDateEnd(): \DateTimeImmutable
    {
        return $this->dateEnd;
    }

    public function getHandlerClass(): string
    {
        return GenerateStatisticByDatesHandler::class;
    }
}