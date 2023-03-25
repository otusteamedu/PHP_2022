<?php

declare(strict_types=1);

namespace Kogarkov\Es\Core\Storage\Mysql;

use Kogarkov\Es\Domain\User\Model\UserModel;

interface StorageCrudInterface
{
    public function create(UserModel $user): int;
    public function findOne(int $id): UserModel;
    public function getAll(): array;
    public function update(UserModel $user): int;
    public function delete(int $id): int;
}
