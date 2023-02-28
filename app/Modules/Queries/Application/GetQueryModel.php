<?php

declare(strict_types=1);

namespace App\Modules\Queries\Application;

use App\Modules\Queries\Domain\Query;

class GetQueryModel
{
    public static function getById(int $id)
    {
        return Query::findOrFail($id);
    }
}
