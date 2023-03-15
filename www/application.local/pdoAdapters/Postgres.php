<?php

namespace app\pdoAdapters;

trait Postgres {
    private function createPdo(): \PDO {
        $pdo = new \PDO(
            'pgsql:host='.$_ENV['POSTGRES_HOST'].';port='.$_ENV['POSTGRES_PORT'].';dbname='.$_ENV['POSTGRES_DB'].';',
            $_ENV['POSTGRES_USER'],
            $_ENV['POSTGRES_PASSWORD']
        );
        if (!$pdo) {
            throw new \Exception("Не могу подключиться к базе!", 500);
        }
        return $pdo;
    }
}
