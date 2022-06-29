<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Request
 *
 * @property int $id
 * @property string $action
 * @property string $data
 * @property string $status
 *
 * @package App\Models
 */
class Request extends Model
{
    /**
     * @var string
     */
    protected $table = 'request';

    /**
     * @var bool
     */
    public $timestamps = false;
}
