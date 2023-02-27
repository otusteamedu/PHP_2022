<?php

namespace App\EventsStorage;

interface EventsStorageInterface
{
    public function testConnection(): string;

    public function addEvent(string $event, string $priority, ...$conditions): bool;

    public function getEvent(...$conditions): string;

    public function flushAll(): void;
}
