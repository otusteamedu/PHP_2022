<?php

declare(strict_types=1);

namespace unsorted\DesignPatterns\DataMapper;

class IdentityMap
{
    private array $mapping;

    public function __construct()
    {
        $this->mapping = [];
    }

    public function set(mixed $id, object $object): void
    {
        $this->mapping[\get_class($object) . '_' . $id] = $object;
    }

    public function exists(mixed $id, string $className): bool
    {
        return isset($this->mapping[$className . '_' . $id]);
    }

    public function get(mixed $id, string $className): ?object
    {
        return $this->mapping[$className . '_' . $id] ?? null;
    }

    public function remove(int $id, string $className): void
    {
        $this->mapping[$className . '_' . $id] = null;
    }
}