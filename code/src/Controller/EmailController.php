<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw5\Controller;

use Nikcrazy37\Hw5\Model\EmailValidator;

class EmailController
{
    public function index()
    {
        require_once ROOT . "/src/view/email/index.php";
    }

    public function check()
    {
        if ($email = $_POST["email"]) {
            try {
                $validator = new EmailValidator($email);
                $result = $validator->validate();
            } catch (\Exception $e) {
                http_response_code($e->getCode());
                $result = $e->getMessage();
            }

            require_once ROOT . "/src/view/email/result.php";
        }

    }
}