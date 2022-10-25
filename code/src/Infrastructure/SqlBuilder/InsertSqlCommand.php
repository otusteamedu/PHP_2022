<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\SqlBuilder;

class InsertSqlCommand extends AbstractSqlCommand
{
    private array $values  = [];

    public function __construct()
    {
        parent::__construct();
        $this->command = 'INSERT INTO ';
    }

    public function value(string $field, $value): self
    {
        $this->values[$field] = $value;
        return $this;
    }

    protected function doBuild(): string
    {
        return ' (' . implode(',', array_keys($this->values)) . self::VALUES .
            implode(',', array_pad([self::PLACEHOLDER], count($this->values), self::PLACEHOLDER)) .
            ')';
    }

    protected function doExecute(): int
    {
        $placeholderValues = [];
        foreach ($this->values as $value) {
            $placeholderValues[] = $value;
        }

        $this->statement->execute($placeholderValues);
        return (int) $this->pdo->lastInsertId();
    }
}