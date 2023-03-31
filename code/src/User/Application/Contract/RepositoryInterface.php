<?php

declare(strict_types=1);

namespace App\User\Application\Contract;

use App\User\Domain\Model\UserModel;

interface RepositoryInterface
{
    public function create(UserModel $user): int;
    public function findOne(int $id): UserModel;
    public function getAll(): array;
    public function update(UserModel $user): int;
    public function delete(int $id): int;
}
