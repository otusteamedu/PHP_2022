<?php

declare(strict_types=1);

namespace App\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Contracts\EventDispatcher\Event;

class LogEvent extends Event
{
    public const NAME = 'log.event';

    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onLogAction(): void
    {
        $this->logger->info('Сработало событие');
    }
}