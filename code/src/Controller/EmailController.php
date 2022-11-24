<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw5\Controller;

use Nikcrazy37\Hw5\Exception\ControllerException;
use Nikcrazy37\Hw5\Exception\EmailValidateException;
use Nikcrazy37\Hw5\Model\EmailValidator;

class EmailController
{
    public function index()
    {
        require_once ROOT . "/src/view/email/index.php";
    }

    /**
     * @throws ControllerException
     */
    public function check()
    {
        if ($email = $_POST["email"]) {
            try {
                $validator = new EmailValidator($email);
                $result = $validator->validate();
            } catch (EmailValidateException $e) {
                throw new ControllerException($e->getMessage(), 400, $e);
            }

            require_once ROOT . "/src/view/email/result.php";
        }

    }
}