<?php

namespace KonstantinDmitrienko\StringValidator\App;

use KonstantinDmitrienko\StringValidator\Response\Response;
use KonstantinDmitrienko\StringValidator\StringValidator\StringValidator;

class App
{
    protected string $string = '';
    protected static string $viewDir = '';

    public function __construct() {
        self::$viewDir = $_SERVER['DOCUMENT_ROOT'] . '/view/';
    }

    public function run(): void
    {
        if (!isset($_POST['string'])) {
            require self::$viewDir . 'components/form.php';
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
