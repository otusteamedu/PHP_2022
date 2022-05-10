<?php

namespace App\Ddd\Application;

interface Repository
{
    public function add($model): bool;
    public function getAll(): array;
    public function delete(): void;
}