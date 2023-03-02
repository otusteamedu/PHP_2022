<?php

namespace App\Application\Gateway\Repository;

interface ProfileRepositoryInterface extends RepositoryInterface
{
    public function nextId(): int;
}