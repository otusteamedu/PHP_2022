<?php

declare(strict_types=1);

namespace App\Service\Storage;

use App\Entity\Event;

interface StorageInterface
{
    public function find(array $params);

    public function save(Event $event);

    public function clear();
}