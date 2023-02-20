<?php

namespace Ivan\Backend;

use Ivan\Backend\Actions\VerifyAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class ValidationService
{
    public function run()
    {
        try {
            $request = Request::createFromGlobals();

            if (!$request->request->has('string')) {
                throw new Exception('Не передан обязательный параметр string');
            }

            $verifyAction = new VerifyAction();
            $verifyAction->run(string: $request->get('string'));

            (new Response('OK', Response::HTTP_OK))->send();
        } catch (\Throwable $throwable) {
            (new Response($throwable->getMessage(), Response::HTTP_FORBIDDEN))->send();
        }
    }


}
