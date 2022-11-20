<?php

namespace Classes;

class Response
{
    /**
     * Send "ok" response.
     *
     * @param string $message
     * @return void
     */
    public function ok(string $message)
    {
        $this->send(200, $message);
    }

    /**
     * Send "Bad request" response.
     *
     * @param string $message
     * @return void
     */
    public function badRequest(string $message)
    {
        $this->send(400, $message);
    }

    /**
     * Send request.
     *
     * @param int $statusCode
     * @param string $message
     * @return void
     */
    public function send(int $statusCode, string $message)
    {
        http_response_code($statusCode);

        echo $message;
    }
}
