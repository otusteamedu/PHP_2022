<?php

namespace app\services;

class DBService {
    private static $connection;
    protected function __construct() {}

    public function connect(): \PDO {
        $dbConfig = require('../config/db.php');
        $pdo = new \PDO($dbConfig['dsn'], $dbConfig['user'], $dbConfig['password']);
        return $pdo;
    }

    public static function get(): self {
        if (null === static::$connection) {
            static::$connection = new static();
        }
        return static::$connection;
    }


}
