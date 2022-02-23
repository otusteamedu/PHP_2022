<?php

namespace KonstantinDmitrienko\StringValidator\App;

use KonstantinDmitrienko\StringValidator\Response\Response;
use KonstantinDmitrienko\StringValidator\StringValidator\StringValidator;
use KonstantinDmitrienko\StringValidator\View\View;

class App
{
    protected string $string = '';
    protected object $view;

    public function __construct() {
        $this->view = new View();
    }

    public function run(): void
    {
        if (!isset($_POST['string'])) {
            $this->view->showForm();
            return;
        }

        $this->string = $_POST['string'];

        if (!$this->string) {
            Response::emptyPost();
        } else if (StringValidator::hasMatchedBrackets($this->string)) {
            Response::success();
        } else {
            Response::failure();
        }
    }
}
