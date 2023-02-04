<?php

namespace Otus\Task12\Core\ORM;

class Databases
{
    private \PDO $pdo;

    public function __construct($config)
    {
        $this->pdo = new \PDO($config['driver'] . ":" . $config['name']);
    }

    public function statement($sql, array $binding = []): bool|\PDOStatement
    {
        $statement = $this->pdo->prepare($sql);
        if($binding){
            foreach ($binding as $column => $value){
                $statement->bindValue(':' . $column, $value);
            }
        }
        $statement->execute();
        return $statement;
    }

    public function lastInsertId(): bool|string
    {
        return $this->pdo->lastInsertId();
    }
}