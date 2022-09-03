<?php

declare(strict_types=1);

namespace Nsavelev\Hw6\Services\Server\DTOs;

class BaseMessageDTO
{
    /**
     * @param string $message
     * @param string $clientSocketFilePath
     */
    public function __construct(
        private readonly string $message,
        private readonly array|int|false $messageOption,
        private readonly string $clientSocketFilePath
    ) {}

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return array|false|int
     */
    public function getMessageOption(): bool|array|int
    {
        return $this->messageOption;
    }

    /**
     * @return string
     */
    public function getClientSocketFilePath(): string
    {
        return $this->clientSocketFilePath;
    }
}