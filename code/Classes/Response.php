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
        $this->send(200, 'OK', $message);
    }

    /**
     * Send "Bad request" response.
     *
     * @param string $message
     * @return void
     */
    public function badRequest(string $message)
    {
        $this->send(200, 'Bad request', $message);
    }

    /**
     * Send request.
     *
     * @param int $statusCode
     * @param string $statusText
     * @param string $message
     * @return void
     */
    public function send(int $statusCode, string $statusText, string $message)
    {
        header("HTTP/1.1 $statusCode $statusText");

        print_r([
            'message'=> $message,
        ]);
    }
}
