<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\Service;

interface ConsumeMessageInterface
{
    public function consume(): void;
}