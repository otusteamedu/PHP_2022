<?php

declare(strict_types=1);

namespace Study\StringValidator;

use Study\StringValidator\Service\StringValidatorService;
use Study\StringValidator\Response\Response;

class App
{
    private StringValidatorService $stringValidatorService;
    private Response $response;

    public function __construct()
    {
        $this->stringValidatorService = new StringValidatorService();
        $this->response = new Response();
    }

    public function run()
    {
        if (!isset($_POST['string'])){
            $this->response->setStatusCode(Response::HTTP_CODE_BAD_REQUEST, "Строка не передана");
            return $this->response->getResponse();
        }
        if ($this->stringValidatorService->validate($_POST['string']))
        {
            $this->response->setStatusCode(Response::HTTP_CODE_OK,"Строка корректа" );

        } else {
            $this->response->setStatusCode(Response::HTTP_CODE_BAD_REQUEST,"Строка некорректа" );

        }
        return $this->response->getResponse();
    }
}