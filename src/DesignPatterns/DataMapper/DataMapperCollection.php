<?php

declare(strict_types=1);

namespace App\DesignPatterns\DataMapper;

class DataMapperCollection
{
    private \PDOStatement $PDOStatement;
    private array $params;
    /**
     * @var callable
     */
    private $initializationFunc;

    private ?array $items = null;

    public function __construct(
        \PDOStatement $PDOStatement,
        array $params,
        callable $initializationFunc
    )
    {
        $this->PDOStatement = $PDOStatement;
        $this->params = $params;
        $this->initializationFunc = $initializationFunc;
    }

    public function getAll(): array
    {
        if (\is_null($this->items)) {
            $this->initializeObjects();
        }

        return $this->items;
    }

    private function initializeObjects(): void
    {
        $this->PDOStatement->execute($this->params);
        $rowItems = $this->PDOStatement->fetchAll(\PDO::FETCH_ASSOC);

        $this->items = \array_map($this->initializationFunc, $rowItems);
    }
}