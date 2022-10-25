<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\SqlBuilder;

use Nikolai\Php\Infrastructure\Connection\Connection;

abstract class AbstractSqlCommand
{
    const WHERE = ' WHERE ';
    const AND = ' AND ';
    const VALUES = ') VALUES (';
    const SET = ' SET ';
    const PLACEHOLDER = '?';

    protected string $command;

    protected string $table;

    protected \PDO $pdo;

    protected \PDOStatement $statement;

    public function __construct()
    {
        $this->pdo = Connection::getInstance()->getConnection();
    }

    public function table(string $tableName): static
    {
        $this->table = $tableName;
        return $this;
    }

    public function build(): string
    {
        return $this->command . $this->table . $this->doBuild();
    }

    abstract protected function doBuild(): string;
    abstract protected function doExecute();

    public function execute()
    {
        $this->statement = $this->pdo->prepare($this->build());
        return $this->doExecute();
    }
}