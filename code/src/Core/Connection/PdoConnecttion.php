<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw12\Core\Connection;

use PDO;
use Nikcrazy37\Hw12\Core\Dto\Connection;

class PdoConnecttion extends \PDO
{
    public static function connection(Connection $connection): PdoConnecttion
    {
        return new PdoConnecttion("pgsql:host={$connection->getHostname()};dbname={$connection->getDatabase()}",
            $connection->getUsername(),
            $connection->getPassword()
        );
    }
}