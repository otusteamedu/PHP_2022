<?php

namespace Ppro\Hw15\Connection;

use Ppro\Hw15\Register;

class PostgresqlConnection
{
    public static function connect(): \PDO
    {
        $params = Register::instance();
        $dsn = sprintf("pgsql:host=%s;port=%d;dbname=%s;",
          $params->getValue('host'),
          $params->getValue('port'),
          $params->getValue('database'),
          );

        try {
            return new \PDO(
              $dsn,
              $params->getValue('user'),
              $params->getValue('password'),
              [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
            );
        } catch(\PDOException $e) {
            echo $e->getMessage();
        }
    }
}