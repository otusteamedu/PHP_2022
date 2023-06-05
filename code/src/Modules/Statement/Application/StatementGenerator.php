<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw16\Modules\Statement\Application;

use Nikcrazy37\Hw16\Modules\Statement\Domain\User;
use Nikcrazy37\Hw16\Modules\Statement\Domain\Statement;

class StatementGenerator
{
    public static function generate(User $user, Statement $statement): string
    {
        return "STATEMENT for {$user->getName()} by date {$statement->getDate()}";
    }
}