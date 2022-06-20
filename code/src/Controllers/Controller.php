<?php

namespace Anosovm\HW5\Controllers;

use Anosovm\HW5\View;

class Controller
{
    protected string $view = 'Views/not-found.php';
    protected array $data = [];

    public function view(): void
    {
        $view = new View($this->view);
        echo $view->show($this->data);
    }
}