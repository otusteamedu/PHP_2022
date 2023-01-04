<?php

namespace AKhakhanova\Hw4;

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
        if ($this->validator->isValidRequest()) {
            return new Response('Valid request');
        }

        return new Response('Invalid parameter "string"', Response::HTTP_BAD_REQUEST);
    }
}
