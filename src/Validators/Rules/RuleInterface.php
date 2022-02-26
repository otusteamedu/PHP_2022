<?php

namespace Philip\Otus\Validators\Rules;

interface RuleInterface
{
    public function make($value): bool;

    public function fail(): array;
}