<?php

namespace Katya\App\Users;

abstract class Controller{

    protected function getTemplate($file, array $data = [])
    {
        extract($data);
        ob_start();
        require_once '../templates/' . $file;
        $page = ob_get_contents();
        ob_clean();
        return $page;
    }
}