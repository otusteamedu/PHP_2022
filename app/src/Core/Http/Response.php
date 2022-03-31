<?php

namespace Nka\Otus\Core\Http;

use Nka\Otus\Core\View;

class Response
{
    public array $headers = [];

    public string|View $body;
    public int $status = 200;


    const JSON = 'application/json';
    const HTML = 'text/html';
    const PLAIN = 'text/plain';

    public function createResponse(
        string|View $body,
        int $status = 200
    ): static
    {
        $this->body = $body;
        $this->status = $status;
        return $this;
    }


    protected function prepareResponse(): string
    {
        if ($this->body instanceof View) {
            $this->headers['Content-Type'] = self::HTML;
            $rawBody = $this->body->renderBody();
        } else {
            $this->headers['Content-Type'] = self::JSON;
            $bodyArray['status'] = $this->status >= 400 ? 'error' : 'success';
            $bodyArray['code'] = $this->status;
            $bodyArray['message'] = $this->body;

            $rawBody = json_encode($bodyArray, JSON_UNESCAPED_UNICODE);
        }
        return $rawBody;
    }

    public function send()
    {
        $stdout = fopen('php://stdout', 'w');
        $rawBody = $this->prepareResponse();
        $this->sendHeaders();
        echo $rawBody;
        fclose($stdout);
    }

    public function sendHeaders()
    {
        http_response_code($this->status);
        array_walk($this->headers, function ($value, $header) {
            header($header . ': ' . $value);
        });
    }

}
