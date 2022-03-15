<?php

namespace Core\Base;

use Core\Exceptions\InvalidArgumentException;
use Core\Traits\ErrorTrait;

class Response
{
    use ErrorTrait;

    /**
     * @var array $headers
     */
    private array $headers = [];
    protected int $status_code = 200;

    /**
     * @param array $data
     * @param int $status
     * @return void
     * @throws InvalidArgumentException
     * @throws \JsonException
     */
    public function sendToJSON(array $data,int $status = 200)
    {
        $this->setStatusCode($status)
             ->setHeader('Content-Type', 'application/json')
             ->sendStatusCode()
             ->sendHeaders();

        echo json_encode($data, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
    }

    /**
     * @param int $status
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setStatusCode(int $status) :Response
    {
        if (is_null($status)) {
            $status = 200;
        }

        $this->status_code = (int)$status;

        if ($this->getIsInvalid()) {
            throw new InvalidArgumentException("The HTTP status code is invalid: $status");
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getStatusCode() :int
    {
        return $this->status_code;
    }

    /**
     * @param array $headers
     * @param bool $replace
     * @return Response
     */
    public function setHeaders(array $headers,bool $replace = true) :Response
    {
        if ($replace){
            $this->headers = $headers;
        } else {
            $this->headers = array_merge($this->headers, $headers);
        }

        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     * @return Response
     */
    public function setHeader(string $name,string $value) :Response
    {
        $this->headers[$name] = $value;

        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders() :array
    {
        return $this->headers;
    }

    /**
     * @param string $name
     * @return string
     */
    public function getHeader(string $name) :string
    {
        return $this->headers[$name] ?? '';
    }

    /**
     * @return Response
     */
    public function sendHeaders() :Response
    {
        if ($this->getHeaders()) {
            foreach ($this->getHeaders() as $name => $value) {
                $name = str_replace(' ', '-', ucwords(str_replace('-', ' ', $name)));
                header("$name: $value");
            }
        }

        return $this;
    }

    /**
     * @return Response
     */
    public function sendStatusCode() :Response
    {
        http_response_code($this->status_code);

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsInvalid() :bool
    {
        return $this->getStatusCode() < 100 || $this->getStatusCode() >= 600;
    }
}