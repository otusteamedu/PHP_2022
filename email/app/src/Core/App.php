<?php

namespace Email\App\Core;

use Email\App\Http\Request;
use Email\App\Http\Response;
use Email\App\Service\EmailValidator;

class App
{
    private Request $request;
    private Response $response;
    private EmailValidator $validator;

    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->validator = new EmailValidator();

    }

    public function run(): void
    {
        try {
            $email = $this->request->post('email');

            $this->validator->validate($email);

            $this->response->toJson([
                'result' => true,
                'message' => 'E-mail корректный!'
            ]);

        } catch (\Exception $e) {
            $this->response->toJson([
                'result' => false,
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }
}