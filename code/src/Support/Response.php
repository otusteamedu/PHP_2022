<?php

namespace Koptev\Support;

class Response
{
    /**
     * @var int
     */
    private int $statusCode = 200;

    /**
     * @var mixed
     */
    private $data = null;

    /**
     * Send "ok" response.
     *
     * @param mixed $data
     * @return void
     */
    public function ok($data = null)
    {
        $this->statusCode = 200;

        $this->data = $data;
    }

    /**
     * Send "Bad request" response.
     *
     * @param mixed $data
     * @return void
     */
    public function badRequest($data = null)
    {
        $this->statusCode = 400;

        $this->data = $data;
    }

    /**
     * Send "Unprocessable" response.
     *
     * @param mixed $data
     * @return void
     */
    public function unprocessable($data = null)
    {
        $this->statusCode = 422;

        $this->data = $data;
    }

    /**
     * Send "Not found" response.
     *
     * @return void
     */
    public function notFound()
    {
        $this->statusCode = 404;
    }

    public function __toString(): ?string
    {
        header('Content-Type', 'application/json');

        http_response_code($this->statusCode);

        return is_array($this->data) || is_object($this->data)
            ? json_encode($this->data)
            : (is_null($this->data) ? '' : $this->data);
    }
}
