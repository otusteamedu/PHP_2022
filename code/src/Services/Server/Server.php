<?php

declare(strict_types=1);

namespace Nsavelev\Hw6\Services\Server;

use Nsavelev\Hw6\Services\Server\DTOs\BaseMessageDTO;
use Nsavelev\Hw6\Services\Server\DTOs\ServerConfigDTO;
use Nsavelev\Hw6\Services\Server\Exceptions\ServerAlreadyStartedException;
use Nsavelev\Hw6\Services\Server\Interfaces\MessageHandlerInterface;
use Nsavelev\Hw6\Services\Server\Interfaces\ServerInterface;
use Nsavelev\Hw6\Services\SocketHelper\Interfaces\SocketHelperInterface;
use Socket;
use Nsavelev\Hw6\Services\SocketHelper\Factories\SocketHelperFactory;

class Server implements ServerInterface
{
    /** @var Server */
    private static Server $server;

    /** @var Socket */
    private Socket $socket;

    /** @var string */
    private string $serverSocketFilePath;

    /** @var string */
    private string $answerSocketFilePath;

    /** @var SocketHelperInterface */
    private SocketHelperInterface $socketHelper;

    /**
     * @param ServerConfigDTO $serverConfigDTO
     */
    private function __construct(ServerConfigDTO $serverConfigDTO)
    {
        $this->serverSocketFilePath = $serverConfigDTO->getServerSocketFilePath();
        $this->answerSocketFilePath = $serverConfigDTO->getAnswerSocketFilePath();
        $this->socketHelper = SocketHelperFactory::getInstance();

        $socket = $this->init();
        $this->socket = $socket;
    }

    /**
     * @param ServerConfigDTO $serverConfigDTO
     * @return Server
     * @throws ServerAlreadyStartedException
     */
    public static function create(ServerConfigDTO $serverConfigDTO): Server
    {
        if (!empty(static::$server)) {
            throw new ServerAlreadyStartedException('Server already started.');
        }

        $server = new self($serverConfigDTO);

        return $server;
    }

    /**
     * @return Socket
     */
    private function init(): Socket
    {
        $socket = $this->socketHelper->create($this->serverSocketFilePath);

        return $socket;
    }

    /**
     * @param MessageHandlerInterface $messageHandler
     * @return void
     */
    public function listen(MessageHandlerInterface $messageHandler): void
    {

        $this->socketHelper->listen(
            $this->socket,
            function ($messageOption, $message) use ($messageHandler) {

                $baseMessageDTO = new BaseMessageDTO(
                    $message,
                    $messageOption,
                    $this->answerSocketFilePath
                );

                $messageHandler->handle($baseMessageDTO);

                return true;
        });
    }

    public function __destruct()
    {
        socket_close($this->socket);
        unlink($this->serverSocketFilePath);

        $this->socketHelper->checkSocketError();
    }
}