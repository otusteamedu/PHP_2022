<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\Service;

interface NotificationSenderInterface
{
    public function send(array $messageBody): bool;
}