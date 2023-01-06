<?php

namespace AKhakhanova\Hw4;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class App
{
    private Validator $validator;

    public function __construct()
    {
        $this->validator = new Validator();
    }

    public function run(): Response
    {
        $errors = $this->validator->checkRequestEmails();
        if (empty($errors)) {
            return new Response('Valid email');
        }

        return new JsonResponse(['errors' => $errors], Response::HTTP_BAD_REQUEST);
    }
}
