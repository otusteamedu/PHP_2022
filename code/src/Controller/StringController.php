<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw4\Controller;

use Nikcrazy37\Hw4\Model\Stringer;

class StringController
{
    /**
     * @return void
     */
    public function index()
    {
        require_once ROOT . "/src/view/string/index.php";
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function check()
    {
        if ($string = $_POST["string"]) {
            try {
                Stringer::validate($string);
            } catch (\Exception $e) {
                http_response_code($e->getCode());
                print_r($e->getMessage());
            }
        }
    }
}