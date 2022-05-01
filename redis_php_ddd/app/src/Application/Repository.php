<?php

namespace App\Ddd\Application;

use App\Ddd\Domain\Model;

interface Repository
{
    public function add($model): bool;
    public function get($request): ?Model;
    public function delete(): void;
}