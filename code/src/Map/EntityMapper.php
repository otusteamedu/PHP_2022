<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw12\Map;

use PDO;

interface EntityMapper
{
    /**
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo);

    /**
     * @param int $id
     * @return Entity
     */
    public function findById(int $id): Entity;

    /**
     * @param array $row
     * @return Entity
     */
    public function insert(array $row): Entity;

    /**
     * @param Entity $ticket
     * @return bool
     */
    public function update(Entity $ticket): bool;

    /**
     * @param Entity $ticket
     * @return bool
     */
    public function delete(Entity $ticket): bool;

    /**
     * @param $id
     * @return Entity|null
     */
    public function getFromMap($id): ?Entity;

    /**
     * @param Entity $obj
     * @return void
     */
    public function addToMap(Entity $obj): void;
}