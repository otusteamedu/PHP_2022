<?php

namespace Otus\App\Controllers;

use Otus\App\Viewer\View;
use Otus\App\Models\Users;
//use PDO;

class UserViewerController
{
    public function allUsers()
    {
        $massif_users = Users::allUsers();
        
        if($massif_users !== null) {
            View::render('user',[
                'title' => 'Все пользователи',
                'massif_users' => $massif_users
            ]);
        } else {
            View::render('404',[
               'title' => 'Упссс',
               'result' => 'Все сломалось....'
            ]);  
        }        
    }

    public function userCompanies()
    {
        $array_companies = Users::getUserCompanies();

        if($array_companies !== null) {
            View::render('comp',[
                'title' => 'Все компании игрока',
                'array_companies' => $array_companies
            ]);
        } else {
            View::render('404',[
                'title' => 'Упссс',
                'result' => 'Все сломалось....'
            ]);
        }
    }
}



    








