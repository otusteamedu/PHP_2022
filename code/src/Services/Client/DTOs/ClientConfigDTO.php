<?php

declare(strict_types=1);

namespace Nsavelev\Hw6\Services\Client\DTOs;

use Nsavelev\Hw6\Services\Client\Exceptions\SocketFilePathIsNotRealException;

class ClientConfigDTO
{
    /** @var string */
    private string $serverSocketFilePath;

    /** @var string */
    private string $answerSocketFilePath;

    /**
     * @param string $serverSocketFilePath
     * @return ClientConfigDTO
     * @throws SocketFilePathIsNotRealException
     */
    public function setServerSocketFilePath(string $serverSocketFilePath): ClientConfigDTO
    {
        $isPathReal = realpath($serverSocketFilePath);

        if (empty($isPathReal)) {
            throw new SocketFilePathIsNotRealException('Socket file path is not a real path.');
        }

        $this->serverSocketFilePath = $serverSocketFilePath;

        return $this;
    }

    /**
     * @param string $answerSocketFilePath
     * @return ClientConfigDTO
     */
    public function setAnswerSocketFilePath(string $answerSocketFilePath): ClientConfigDTO
    {
        $this->answerSocketFilePath = $answerSocketFilePath;
        return $this;
    }

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