<?php

namespace Redis\App\Repository;

use Redis\App\Model\Model;

interface Repository
{
    public function add($model): bool;
    public function get($request): ?Model;
    public function delete(): void;
}