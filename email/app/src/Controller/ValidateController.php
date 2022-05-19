<?php

namespace Email\App\Controller;

use Email\App\Http\Request;
use Email\App\Http\Response;
use Email\App\Service\EmailValidator;

class ValidateController
{
    private Request $request;
    private Response $response;
    private EmailValidator $validator;

    public function __construct(Request $request, Response $response, EmailValidator $validator)
    {
        $this->request = $request;
        $this->response = $response;
        $this->validator = $validator;
    }

    public function validateEmail(): void
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