<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\SqlBuilder;

final class DeleteSqlCommand extends AbstractSqlCommand
{
    private array $where;

    public function __construct()
    {
        parent::__construct();
        $this->command = 'DELETE FROM ';
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

    protected function doExecute(): bool
    {
        $placeholderValues = [];
        foreach ($this->where as $value) {
            $placeholderValues[] = $value;
        }

        return $this->statement->execute($placeholderValues);
    }
}