<?php

namespace App\Ddd\Domain;

interface Model
{
    public static function create(): self;
    public function toArray(): array;
}
