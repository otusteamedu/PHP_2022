<?php

namespace Mselyatin\Project15\src\datamapper\interfaces;

use Mselyatin\Project15\src\common\interfaces\IdentityInterface;

/**
 * Interface DataMapperInterface
 * @package Mselyatin\Project6\src\datamapper\interfaces
 */
interface DataMapperInterface
{
    public function findById(int $id);
    public function all(int $limit, ?int $offset = null);

    public function save(IdentityInterface $identity): bool;
    public function insert(IdentityInterface $identity): int;
    public function update(IdentityInterface $identity): bool;
    public function delete(IdentityInterface $identity): bool;
}