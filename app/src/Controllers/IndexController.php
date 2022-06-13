<?php

namespace Katya\App\Controllers;

use Katya\App\Users\Controller;

class IndexController extends Controller
{
    public function index()
    {
        echo $this->getTemplate('start.php');
    }
}