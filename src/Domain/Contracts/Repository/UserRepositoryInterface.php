<?php

declare(strict_types=1);

namespace Domain\Contracts\Repository;

interface UserRepositoryInterface
{
    /**
     * @param string $username
     * @return array
     */
    public function getUserByUsername(string $username): array;
}
