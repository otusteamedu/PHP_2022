<?php

namespace Otus\Mvc\Application\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $timestamps = false;

    protected $table = 'users';

}
