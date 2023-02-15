<?php

namespace Ppro\Hw15\Connection;

use Ppro\Hw15\Register;

class PostgresqlConnection
{
    public static function connect(): \PDO
    {
        $dsn = sprintf("pgsql:host=%s;port=%d;dbname=%s;",
              getenv('pg_host'),
              getenv('pg_port'),
              getenv('pg_database'),
          );

        try {
            return new \PDO(
              $dsn,
              getenv('pg_user'),
              getenv('pg_password'),
              [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
            );
        } catch(\PDOException $e) {
            echo $e->getMessage();
        }
    }
}