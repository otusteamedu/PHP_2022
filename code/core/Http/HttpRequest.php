<?php

namespace Kogarkov\Es\Core\Http;

use Kogarkov\Es\Core\Http\Contract\HttpRequestInterface;

class HttpRequest //implements HttpRequestInterface
{
    private $get = [];
    private $raw_post = [];
    private $request = [];
    private $server = [];

    public function __construct()
    {
        $this->get = $this->clean($_GET);
        $this->raw_post = file_get_contents("php://input");
        $this->request = $this->clean($_REQUEST);
        $this->server = $this->clean($_SERVER);
    }

    public function getGetParam(string $key)
    {
        return isset($this->get[$key]) ? $this->get[$key] : null;
    }

    public function getRawPostBody()
    {
        return $this->raw_post;
    }

    public function getRawPostParam(string $key)
    {
        return isset($this->raw_post[$key]) ? $this->raw_post[$key] : null;
    }

    public function getRequestParam(string $key)
    {
        return isset($this->request[$key]) ? $this->request[$key] : null;
    }

    public function getServerParam(string $key)
    {
        return isset($this->server[$key]) ? $this->server[$key] : null;
    }

    private function clean($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                unset($data[$key]);

                $data[$this->clean($key)] = $this->clean($value);
            }
        } else {
            $data = htmlspecialchars($data, ENT_COMPAT, 'UTF-8');
        }

        return $data;
    }
}
