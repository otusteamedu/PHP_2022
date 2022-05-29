<?php
namespace App\Controllers;

use App\Users\Controller;

class IndexController extends Controller
{
    public function index()
    {
        echo $this->getTemplate('start.php');
    }
}