<?php

declare(strict_types=1);

namespace Nsavelev\Hw6\Services\Server\Handlers;

use Nsavelev\Hw6\Services\Client\Client;
use Nsavelev\Hw6\Services\Client\DTOs\ClientConfigDTO;
use Nsavelev\Hw6\Services\Server\DTOs\BaseMessageDTO;
use Nsavelev\Hw6\Services\Server\Interfaces\MessageHandlerInterface;

class BaseMessageHandler implements MessageHandlerInterface
{
    /**
     * @param BaseMessageDTO $baseMessageDto
     * @return void
     * @throws \Nsavelev\Hw6\Services\Client\Exceptions\SocketFilePathIsNotRealException
     */
    public function handle(BaseMessageDTO $baseMessageDto): void
    {
        $answerSocketFilePath = $baseMessageDto->getClientSocketFilePath();

        $clientMessage = $baseMessageDto->getMessage();
        $messageOption = $baseMessageDto->getMessageOption();

        echo "message: $clientMessage \n";
        echo "message option: $messageOption\n";

//        $message = "Received $messageOption bytes";

//        $this->sendMessageToClient($answerSocketFilePath, $message);
    }

    /**
     * @param string $answerSocketFilePath
     * @param string $message
     * @return void
     * @throws \Nsavelev\Hw6\Services\Client\Exceptions\SocketFilePathIsNotRealException
     */
    private function sendMessageToClient(string $answerSocketFilePath, string $message): void
    {
        $clientConfigDTO = (new ClientConfigDTO())
            ->setServerSocketFilePath($answerSocketFilePath);

        $client = new Client($clientConfigDTO);
        $client->connectToSocket()
            ->sendMessage($message);
    }
}
