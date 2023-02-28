<?php

declare(strict_types=1);

namespace Nemizar\Php2022\Chat\Config;

class Config
{
    private string $serverSock;

    private string $clientSock;

    public function __construct(string $serverSock, string $clientSock)
    {
        $this->serverSock = $serverSock;
        $this->clientSock = $clientSock;
    }

    public function getServerSock(): string
    {
        return $this->serverSock;
    }

    public function getClientSock(): string
    {
        return $this->clientSock;
    }
}
