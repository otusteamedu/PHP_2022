<?php

namespace Otus\App\Services;

use Otus\App\Models\Users;
use Otus\App\Viewer\View;

class UserService
{
    public static function allUsersServ(): void {
        View::render('user', [
            'title' => 'Все пользователи',
            'massif_users' => Users::allUsers()
        ]);
    }

    public static function getUserCompaniesServ(): void {
        View::render('comp', [
            'title' => 'Все компании игрока',
            'array_companies' => Users::getUserCompanies()
        ]);
    }
}