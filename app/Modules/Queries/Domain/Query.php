<?php

declare(strict_types=1);

namespace App\Modules\Queries\Domain;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static findOrFail(int $id)
 */
class Query extends Model
{
    protected $guarded = ['id'];
}
