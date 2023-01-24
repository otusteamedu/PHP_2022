<?php

namespace Otus\Mvc\Application\Controllers;

use Otus\Mvc\Application\Services\UserService;

class UserAuthController
{
    public function loginUser()
    {
        UserService::userLoginServ();
    }

    public function logoutUser()
    {
        UserService::userLogoutServ();
    }
}
