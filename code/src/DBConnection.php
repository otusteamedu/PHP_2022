<?php

namespace Study\Cinema;

use PDO;


class DBConnection
{
    private PDO|null $pdo;
    public function __construct()
    {
        $db_host = getenv('DATABASE_HOST');
        $db_port = getenv('DATABASE_PORT');
        $db_name = getenv('DATABASE_NAME');
        $db_user = getenv('DATABASE_USER');
        $db_password = getenv('DATABASE_PASSWORD');
        try {
            $dsn = "pgsql:host=$db_host;port=$db_port;dbname=$db_name;";
            $this->pdo = new PDO($dsn, $db_user, $db_password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION] );
            if ($this->pdo ) {
                echo "Connected to the $db_name database successfully!";
            }

        } catch (PDOException $e) {
            die( $e->getMessage() );
        }

    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }



}