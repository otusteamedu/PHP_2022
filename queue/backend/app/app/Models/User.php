<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function getUserIdentifier(): ?int
    {
        return 1;
    }

    public function getBankSecretToken(): ?string
    {
        return 'ldfkbnlbewmgenrgdbkgbdbnndfn393e8rtreghbvsdv';
    }

    public function getTelegramChatId(): ?string
    {
        return '39745100350';
    }

    public function getEmail(): ?string
    {
        return 'login@domain.com';
    }
}
