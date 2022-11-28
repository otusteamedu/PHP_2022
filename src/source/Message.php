<?php

namespace TemaGo\CommandChat;

class Message
{
    public string $from;
    public string $message;

    public function __construct(string $from, string $message)
    {
        $this->from = $from;
        $this->message = $message;
    }

    public function getLength() : int
    {
        return mb_strlen($this->message);
    }
}
