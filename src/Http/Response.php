<?php

namespace App\Http;

class Response
{
    private ?string $data;
    private int $code;
    private ?string $statusText;


    public function __construct(?string $data = '', int $code = 200, ?string $statusText = '')
    {
        $this->data = $data;
        $this->code = $code;
        $this->statusText = $statusText;
    }

    public function send()
    {
        header(sprintf('HTTP/1.1 %s %s', $this->code, $this->statusText), true, $this->code);

        echo $this->data;
    }
}
