<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\SqlBuilder;

final class SelectSqlCommand extends AbstractSqlCommand
{
    private array $where;

    public function __construct()
    {
        parent::__construct();
        $this->command = 'SELECT * FROM ';
    }

    public function where(string $field, $value): self
    {
        $this->where[$field] = $value;
        return $this;
    }

    protected function doBuild(): string
    {
        $result = [];
        foreach ($this->where as $field => $value) {
            $result[] = $field . '=' . self::PLACEHOLDER;
        }

        return self::WHERE . implode(self::AND, $result);
    }

    protected function doExecute(): array
    {
        $placeholderValues = [];
        foreach ($this->where as $value) {
            $placeholderValues[] = $value;
        }

        $this->statement->setFetchMode(\PDO::FETCH_ASSOC);
        $this->statement->execute($placeholderValues);
        $result = $this->statement->fetchAll();

        return $result ?? [];
    }
}