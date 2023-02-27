<?php

declare(strict_types=1);

namespace Eliasj\Hw16\Modules\Form\Domain;

class GenerateExpenses
{
    public static function run(): int
    {
        return mt_rand(999, 9999);
    }
}
