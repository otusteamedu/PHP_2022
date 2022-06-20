<?php

namespace Igor\Php2022;

interface ChatServerTransportInterface
{
    public function getMessage(): string;
    public function sendMessage(string $message): void;
}