<?php

declare(strict_types=1);

namespace App\Modules\Queries\Application;

use App\Modules\Queries\Domain\Query;
use App\Modules\Queries\Domain\QueryStatusEnum;

class CreateQueryAction
{
    public static function run(string $name)
    {
        $query = new Query();
        $query->name = $name;
        $query->status = QueryStatusEnum::created;

        $query->save();

        dispatch(new QueryJob($query));

        return $query->id;
    }
}
