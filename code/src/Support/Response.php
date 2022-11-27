<?php

namespace Koptev\Support;

use Throwable;

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
     * Set status "OK" for response.
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
     * Set status "Bad request" for response.
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
     * Set status "Unprocessable" for response.
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
     * Set status "Not found" for response.
     *
     * @return void
     */
    public function notFound(Throwable $e)
    {
        $this->statusCode = 404;

        $this->data = 'Error:' . $e->getMessage();
    }

    /**
     * Set status "Method not allowed" for response.
     *
     * @return void
     */
    public function methodNotAllowed()
    {
        $this->statusCode = 405;
    }

    /**
     * Set status "Server error" for response.
     *
     * @param Throwable|null $e
     * @return void
     */
    public function serverError(?Throwable $e = null)
    {
        $this->statusCode = 500;

        $this->data = $e->getTrace();
    }

    /**
     * @return string|null
     */
    public function __toString(): ?string
    {
        header('Content-Type', 'application/json');
        header('Accept', 'application/json');

        http_response_code($this->statusCode);

        return is_array($this->data) || is_object($this->data)
            ? json_encode($this->data)
            : (is_null($this->data) ? '' : $this->data);
    }
}
