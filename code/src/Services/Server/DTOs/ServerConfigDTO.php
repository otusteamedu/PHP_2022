<?php

declare(strict_types=1);

namespace Nsavelev\Hw6\Services\Server\DTOs;

class ServerConfigDTO
{
    /**
     * @param string $serverSocketFilePath
     * @param string $answerSocketFilePath
     */
    public function __construct(
        private readonly string $serverSocketFilePath,
        private readonly string $answerSocketFilePath,
    ) {}

    /**
     * @return string
     */
    public function getServerSocketFilePath(): string
    {
        return $this->serverSocketFilePath;
    }

    /**
     * @return string
     */
    public function getAnswerSocketFilePath(): string
    {
        return $this->answerSocketFilePath;
    }
}