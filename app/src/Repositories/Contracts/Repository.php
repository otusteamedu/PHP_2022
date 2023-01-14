<?php

declare(strict_types=1);

namespace App\Src\Repositories\Contracts;

use App\Src\Event\Event;

interface Repository
{
    public function insert(Event $event): void;

    public function getAllEvents(Event $event): array;

    public function deleteAll(): void;

    public function deleteConcreteEvent(Event $event): void;

    public function getConcreteEvent(Event $event): array;
}
