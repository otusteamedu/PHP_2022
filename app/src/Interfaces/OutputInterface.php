<?php

declare(strict_types=1);

namespace HW10\App\Interfaces;

interface OutputInterface
{
    public function echo(array $outputObjs): void;
    public function echoMessage(string $message): void;
}
