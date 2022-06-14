<?php

namespace Katya\hw5\Controllers;

use Katya\hw5\Users\Controller;

class IndexController extends Controller
{
    public function index()
    {
        echo $this->getTemplate('start.php');
    }
}