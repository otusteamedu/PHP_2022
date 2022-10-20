<?php

namespace Onbalt\Validator;

class ValidatorResponse
{
    private array $headers = [];
    private string $response;

    public function __construct(bool $resultIsValid)
    {
        $this->headers[] = 'X-Container: ' . $_SERVER['HOSTNAME'];

        if ($resultIsValid) {
            $this->headers[] = 'Status: 200 OK';
            $this->response = 'всё хорошо';
        } else {
            $this->headers[] = 'Status: 400 Bad Request';
            $this->response = 'всё плохо';
        }
    }

    public function flushResponse() {
        foreach ($this->headers as $header) {
            header($header);
        }
        exit($this->response);
    }

}