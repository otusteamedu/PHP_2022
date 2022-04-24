<?php

namespace App\Db\Database;

use Closure;
use PDOStatement;
use WS\Utils\Collections\CollectionFactory;

class QueryBuilder
{
    private const ID_FIELD = 'id';

    private const INSERT_PATTERN = 'INSERT INTO %s(%s) VALUES (%s)';
    private const UPDATE_PATTERN = 'UPDATE %s SET %s WHERE id=%s';
    private const DELETE_PATTERN = 'DELETE FROM %s WHERE id = ?';
    private const SELECT_PATTERN = 'SELECT %s FROM %s';
    private const WHERE_PATTERN = 'WHERE %s';

    private \PDO $pdo;
    private string $table = '';
    private array $fields = [];
    private string $where = '';
    private PDOStatement $query;

    public function __construct(Connector $connector)
    {
        $this->pdo = $connector::connect();
    }

    public function table(string $name): self
    {
        $this->table = $name;
        return $this;
    }

    public function insert(Entity $entity): int
    {
        $refClass = new \ReflectionClass(get_class($entity));

        $fields = CollectionFactory::from($refClass->getProperties())
            ->stream()
            ->filter($this->isNotId())
            ->reduce(function (\ReflectionProperty $property, $carry = null) {
                $carry .= $property->getName() . ',';
                return $carry;
            });
        $fields = $this->deleteLastChars($fields);

        $values = CollectionFactory::from($refClass->getProperties())
            ->stream()
            ->filter($this->isNotId())
            ->reduce(function (\ReflectionProperty $property, $carry = null) {
                $carry .= '?,';
                return $carry;
            });
        $values = $this->deleteLastChars($values);

        $prepare = $this->pdo->prepare(sprintf(self::INSERT_PATTERN, $this->table, $fields, $values));

        $prepare->execute($this->getEntityValues($entity));

        return $this->pdo->lastInsertId();
    }

    public function update(Entity $entity): void
    {
        $refClass = new \ReflectionClass(get_class($entity));

        $fields = CollectionFactory::from($refClass->getProperties())
            ->stream()
            ->filter($this->isNotId())
            ->reduce(function (\ReflectionProperty $property, $carry = null) {
                $carry .= $property->getName() . '=?,';
                return $carry;
            });
        $fields = $this->deleteLastChars($fields);

        $prepare = $this->pdo->prepare(sprintf(self::UPDATE_PATTERN, $this->table, $fields, $entity->getId()));

        $prepare->execute($this->getEntityValues($entity));
    }

    public function delete(Entity $entity): void
    {
        $prepare = $this->pdo->prepare(sprintf(self::DELETE_PATTERN, $this->table));
        $prepare->execute([$entity->getId()]);
    }

    public function select(array $fields): self
    {
        $this->fields = $fields;
        return $this;
    }

    public function from(string $table): self
    {
        $this->table = $table;
        return $this;
    }

    public function where(string $where): self
    {
        $this->where = $where;
        return $this;
    }

    public function getQuery(): self
    {
        $fields = CollectionFactory::from($this->fields)
            ->stream()
            ->reduce(function (string $field, $carry = null) {
                $carry .= $field . ', ';
                return $carry;
            });
        $fields = $this->deleteLastChars($fields, 2);

        $sql = sprintf(self::SELECT_PATTERN, $fields, $this->table);
        $sql .= $this->where ? sprintf(self::WHERE_PATTERN, $this->where) : '';

        $this->query = $this->pdo->prepare($sql);
        $this->query->execute([]);

        return $this;
    }

    public function getResult(): ?array
    {
        $rows = CollectionFactory::empty();
        while ($row = $this->query->fetch(\PDO::FETCH_ASSOC)) {
            $rows->add($row);
        }

        return $rows->toArray();
    }

    public function getCount(): int
    {
        return $this->query->rowCount();
    }

    public function isNotId(): Closure
    {
        return static function (\ReflectionProperty $property): bool {
            return $property->getName() !== self::ID_FIELD;
        };
    }

    private function getEntityValues(Entity $entity): array
    {
        $data = $entity->toArray();
        unset($data[self::ID_FIELD]);

        return array_values($data);
    }

    private function deleteLastChars(string $string, $count = 1): string
    {
        return substr($string, 0,  (strlen($string) - $count));
    }
}
