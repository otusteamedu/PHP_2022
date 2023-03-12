<?php

declare(strict_types=1);

namespace App\Infrastructure\Queue\BankAccount;

use App\Application\Queue\BusInterface;
use App\Application\Queue\HandlerInterface;
use App\Application\UseCase\BankAccount\StatisticGenerator;

class GenerateStatisticByDatesHandler implements HandlerInterface
{
    public function __construct(
        private readonly StatisticGenerator $statisticGenerator,
        private readonly BusInterface $bus
    ) {
    }

    public function handle(GenerateStatisticByDatesMessage $message): void
    {
        $statistics = $this->statisticGenerator->generate($message->getDateStart(), $message->getDateEnd());
        $this->printStats($statistics);
        $this->sendStatsByEmail($statistics);
        $this->sendTelegramNotification($statistics);
    }

    private function printStats(string $statistics): void
    {
        print_r($statistics);
    }

    private function sendStatsByEmail(string $statistics): void
    {
        $message = new SendingEmailMessage($statistics);
        $this->bus->dispatch($message);
    }

    private function sendTelegramNotification(string $statistics): void
    {
        $message = new TelegramNotificationMessage($statistics);
        $this->bus->dispatch($message);
    }
}