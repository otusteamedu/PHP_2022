<?php

namespace Dmitry\App\Core;

class Response
{

    private string $content;

    private int $status = 200;

    private function __construct(string $content)
    {
        $this->content = $content;
    }

    public function __invoke()
    {
        http_response_code($this->status);

        echo $this->content;
    }

    public function withStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public static function make(string $content): self
    {
        return new Response($content);
    }
}