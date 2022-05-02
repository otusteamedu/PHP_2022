<?php

declare(strict_types=1);

namespace Mselyatin\Project6\src\controllers;

use Mselyatin\Project6\src\classes\Controller;
use Mselyatin\Project6\src\classes\JSONResponse;
use Mselyatin\Project6\src\services\EmailValidationService;
use Symfony\Component\HttpFoundation\Request;

/**
 * @ValidatorController
 * @\Mselyatin\Project6\src\controllers\ValidatorController
 */
class ValidatorController extends Controller
{
    /**
     * @return void
     * @throws \JsonException
     */
    public function emailValidation(): void
    {
        $request = new Request(
            $_GET,
            $_POST,
            [],
            $_COOKIE,
            $_FILES,
            $_SERVER
        );
        $response = new JSONResponse();

        $email = $request->get('email');

        if ($email) {
            $emailValidationService = new EmailValidationService($email);
            $result = $emailValidationService->validation();

            $response->addItem('status', 'success');
            $response->addItem('result', $result);
        } else {
            $response->addItem('status', 'error');
            $response->addItem('message', "Parameter email is empty");
        }

        echo $response->buildResponse();
    }
}