<?php

declare(strict_types=1);

namespace App\SearchEngine;

use App\SearchEngine\Mechanisms\Connection;

final class Engine
{
    private Connection $connection;

    public function __construct()
    {
        $this->connection = new Connection();
    }

    public function startSystem()
    {
        $response = $this->connection->connect();

        $info = $response->info()->asArray();

        var_dump($info);
    }
}
