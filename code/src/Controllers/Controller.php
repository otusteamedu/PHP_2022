<?php

namespace Roman\Hw5\Controllers;

use Roman\Hw5\View;

class Controller
{
    protected array $data;
    protected string $layout;

    public function __construct(string $layout='layouts/404.php',array $data=array()){
        $this->data=$data;
        $this->layout=$layout;
    }

    public function run(): void
    {
        $view = new View($this->layout);
        echo $view->show($this->data);
    }

}