<?php

namespace App\Http;

class ExceptionHandler
{
    public function __construct()
    {
        \set_exception_handler(fn (\Exception $exception) => $this->handle($exception));
    }

    public function handle(\Exception $exception)
    {
        $response = new Response($exception->getMessage(), 400);
        $response->send();
        die();
    }
}
