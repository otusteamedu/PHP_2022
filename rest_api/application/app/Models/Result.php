<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Request
 *
 * @property int $id
 * @property string $action
 * @property string $data
 * @property int $requestId
 *
 * @package App\Models
 */
class Result extends Model
{
    /**
     * @var string
     */
    protected $table = 'result';

    /**
     * @var bool
     */
    public $timestamps = false;
}
