<?php

declare(strict_types=1);


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * Таблица БД, ассоциированная с моделью.
     *
     * @var string
     */
    protected $table = 'tasks';

    public $timestamps = false;

    protected $fillable = [
        'uuid', 'number', 'result'
    ];
}
