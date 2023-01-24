<?php

namespace Otus\Mvc\Application\Controllers;

use Otus\Mvc\Application\Services\UserService;
use Otus\Mvc\Application\Viewer\View;

class UserRegController
{
    public function userRegistration()
    {
        UserService::userRegServ();
    }
    
    public function newUser(): View
    {
        View::render('noreg',[
            'title' => 'Страница регистрации',
            'result' => 'Зарегистрируйтесь'
        ]);
    }
}
