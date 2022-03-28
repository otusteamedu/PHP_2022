<?php

namespace hw4\core;

class Request
{
    protected string $method = '';
    protected array $body = [];
    protected array $headers = [];
    protected string $uri;

    public function __construct()
    {
        $this->setMethod();
        $this->setHeaders();
        $this->setBody();
        $this->setUri();
    }

    public function setMethod()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    public function setBody()
    {
        $stringBody = fgets(fopen('php://input', 'r+'));
        if ($unserializable = json_decode($stringBody, true)) {
            $this->body = $unserializable;
        } else {
            parse_str($stringBody, $this->body);
        }
    }

    public function setHeaders()
    {
        $this->headers = getallheaders();
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getBody(): array
    {
        return $this->body;
    }

    public function getValue(string $name)
    {
        return $this->body[$name] ?? null;
    }

    public function setUri()
    {
        $this->uri = $_SERVER['REQUEST_URI'];
    }

    public function getUri(): string
    {
        return $this->uri;
    }
}