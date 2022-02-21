<?php

namespace Otus\App\Core;

use Otus\App\Http\Request;
use Otus\App\Http\Response;
use Otus\App\Service\StringValidator;

class App
{
    private Request $request;
    private Response $response;
    private StringValidator $validator;

    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->validator = new StringValidator();
    }

    public function run(): void
    {
        try {
            $string = $this->request->post('string');
            $this->validator->validate($string);

            $this->response->toJson([
                'result' => true,
                'message' => 'Валидация прошла успешно!'
            ]);

        } catch (\Exception $e) {
            $this->response->toJson([
                'result' => false,
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }
}