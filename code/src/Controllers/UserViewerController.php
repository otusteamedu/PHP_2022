<?php

namespace Otus\App\Controllers;

use Otus\App\Services\UserService;

class UserViewerController
{
    public function allUsers()
    {
        UserService::allUsersServ();
    }

    public function userCompanies()
    {
        UserService::getUserCompaniesServ();
    }
}



    








