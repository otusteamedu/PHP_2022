<?php

namespace Patterns\App\Application;

use Patterns\App\Domain\Entity\Entity;

interface QueryBuilderInterface
{
    public function table(string $name): self;
    public function insert(Entity $entity): int;
    public function update(Entity $entity): bool;
    public function delete(Entity $entity): void;
    public function select(array $fields): self;
    public function from(string $table): self;
    public function where(string $where): self;
    public function getQuery(): self;
    public function getResult(): ?array;
    public function getCount(): int;
}