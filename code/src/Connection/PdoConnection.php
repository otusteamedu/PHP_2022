<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw12\Connection;

use PDO;
use Nikcrazy37\Hw12\Dto\DtoConnection;

class PdoConnection
{
    public static function connection(DtoConnection $connection): PDO
    {
        return new PDO("pgsql:host={$connection->getHostname()};dbname={$connection->getDatabase()}",
            $connection->getUsername(),
            $connection->getPassword()
        );
    }
}