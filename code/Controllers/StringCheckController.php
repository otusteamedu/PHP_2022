<?php

namespace Otus\Mvc\Controllers;

use Otus\Mvc\Core\View;
use Otus\Mvc\Services\StringService;



class StringCheckController
{
    public function checkEmail()
    {
        StringService::checkEmailServ();
    }

    public function filterString()
    {
        StringService::checkStringServ();
    }

}
