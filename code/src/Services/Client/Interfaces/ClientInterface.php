<?php

namespace Nsavelev\Hw6\Services\Client\Interfaces;

interface ClientInterface
{
    /**
     * @return $this
     */
    public function connectToSocket(): self;

    /**
     * @param string $message
     * @return void
     */
    public function sendMessage(string $message): void;
}