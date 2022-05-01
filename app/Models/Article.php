<?php

namespace App\Models;

use App\Models\Traits\HasSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property string title
 * @property string body
 * @property array  tags
 */
class Article extends Model
{
    use HasFactory;
    use HasSearch;

    protected $casts = [
        'tags' => 'array',
    ];

    public $fillable = [
        'id',
        'title',
        'body',
        'tags',
    ];
}
