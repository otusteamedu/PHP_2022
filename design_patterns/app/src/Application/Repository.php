<?php

namespace Patterns\App\Application;

use Patterns\App\Domain\Entity\Entity;

interface Repository
{
    public function findById(int $id): ?Entity;
}