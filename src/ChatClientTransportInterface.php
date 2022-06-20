<?php

namespace Igor\Php2022;

interface ChatClientTransportInterface
{
    public function sendMessage(string $message): void;

    public function getReply(): string;
}