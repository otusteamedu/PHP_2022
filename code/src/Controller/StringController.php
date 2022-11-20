<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw4\Controller;

use Nikcrazy37\Hw4\Model\Stringer;

class StringController
{
    public function index()
    {
        require_once "src/view/string/index.php";
    }

    public function check()
    {
        if ($string = $_POST["string"]) {
            try {
                Stringer::isCorrect($string);
            } catch (\Exception $e) {
                http_response_code($e->getCode());
                print_r($e->getMessage());
            }
        }
    }
}