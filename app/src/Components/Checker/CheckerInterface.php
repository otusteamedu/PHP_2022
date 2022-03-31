<?php

namespace Nka\Otus\Components\Checker;

interface CheckerInterface
{
    public function check(string $string) : bool;
}