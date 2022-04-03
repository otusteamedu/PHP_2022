<?php

namespace Redis\App\Model;

interface Model
{
    public static function create(): self;
    public function toArray(): array;
}
