<?php

declare(strict_types=1);

namespace App\DataMapper;

use App\Entity\Client;

abstract class AbstractDataMapper
{
    abstract public function findOne(int $id): Client;

    abstract public function insert(array $raw): Client;

    abstract public function update(Client $client): bool;

    abstract public function delete(Client $client): bool;
}
