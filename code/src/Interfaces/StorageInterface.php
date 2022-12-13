<?php

declare(strict_types=1);

namespace Otus\App\Interfaces;

use Otus\App\Model\Event;

interface StorageInterface
{
    public function saveEvent(Event $event): bool;

    public function getEvent(array $params): array;

    public function deleteEvents(string $key): bool;


}
