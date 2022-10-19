<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\SqlBuilder;

class UpdateSqlCommand extends AbstractSqlCommand
{
    private array $values;

    private array $where;

    public function __construct()
    {
        parent::__construct();
        $this->command = 'UPDATE ';
    }

    public function where(string $field, $value): self
    {
        $this->where[$field] = $value;
        return $this;
    }

    public function value(string $field, $value): self
    {
        $this->values[$field] = $value;
        return $this;
    }

    protected function doBuild(): string
    {
        $values = [];
        foreach ($this->values as $field => $value) {
            $values[] = $field . '=' . self::PLACEHOLDER;
        }

        $result = [];
        foreach ($this->where as $field => $value) {
            $result[] = $field . '=' . self::PLACEHOLDER;
        }

        return self::SET . implode(',', $values) . self::WHERE .
            implode(self::AND, $result);
    }

    protected function doExecute(): bool
    {
        $placeholderValues = [];
        foreach ($this->values as $value) {
            $placeholderValues[] = $value;
        }

        foreach ($this->where as $value) {
            $placeholderValues[] = $value;
        }

        return $this->statement->execute($placeholderValues);
    }
}