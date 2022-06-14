<?php

namespace App\Service\EventService\Repository;

use App\Entity\Event;

interface EventRepositoryInterface
{
    public function get(): array;

    public function findByParams(array $inputParams): ?Event;

    public function add(Event $event): Event;

    public function findById(int $id): ?Event;

    public function remove(Event $event): void;

}
