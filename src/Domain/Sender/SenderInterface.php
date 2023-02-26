<?php

declare(strict_types=1);

namespace DKozlov\Otus\Domain\Sender;

interface SenderInterface
{
    public function send(SenderMessage $message): bool;
}