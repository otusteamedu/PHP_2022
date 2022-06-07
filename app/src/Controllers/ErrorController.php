<?php

namespace Katya\App\Controllers;

class ErrorController
{
    public function error404(){
        echo $this->getTemplate('404.php');
    }

    public function getTemplate($file, array $data = [])
    {
        extract($data);
        return require_once '../templates/' . $file;
    }
}