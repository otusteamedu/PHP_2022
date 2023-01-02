<?php

namespace App\Infrastructure\Command;

interface CommandInterface
{
    public static function getDescription(): string;
    public function execute(): void;
}