<?php

namespace Unixsocket\App\Socket;

interface SocketService
{
    public function connect(): void;
    public function run(): void;
    public function read(): string;
    public function write(string $message);
    public function close(): void;
    public function show(string $message): void;
}
