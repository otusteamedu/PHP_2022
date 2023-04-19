<?php

declare(strict_types=1);

namespace Svatel\Code\Application\SendMessage;

final class Message
{
    private string $title;
    private string $body;

    public function __construct(string $title, string $body)
    {
        $this->title = $title;
        $this->body = $body;
    }
}
