<?php

declare(strict_types=1);

namespace Nsavelev\Hw6\App\Console\Commands;

use Nsavelev\Hw6\App\Interfaces\CommandInterface;
use Nsavelev\Hw6\Services\Client\Client;
use Nsavelev\Hw6\Services\Client\DTOs\ClientConfigDTO;
use Nsavelev\Hw6\Services\Config\Config;

class ClientCommand implements CommandInterface
{
    /**
     * @return void
     * @throws \Nsavelev\Hw6\Services\Client\Exceptions\SocketFilePathIsNotRealException
     */
    public function handle(): void
    {
        $config = Config::getInstance();
        $serverSocketFilePath = $config->get('app.server_socket_filename_with_path');
        $clientSocketFilePath = $config->get('app.client_socket_filename_with_path');

        $clientConfigDTO = (new ClientConfigDTO())
            ->setServerSocketFilePath($serverSocketFilePath)
            ->setAnswerSocketFilePath($clientSocketFilePath);

        $client = new Client($clientConfigDTO);
        $client->connectToSocket();

        echo "Для завершения отправки сообщений на сервер нажмите Enter.\n";

        while (true) {
            $userText = trim(fgets(STDIN));

            if ($userText === '') {
                break;
            }

            $serverAnswer = $client->sendMessageWithConfirm($userText);

            echo "$serverAnswer\n";
        }
    }
}