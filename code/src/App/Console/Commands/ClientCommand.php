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

        try {

            $clientConfigDTO = (new ClientConfigDTO())
                ->setServerSocketFilePath($serverSocketFilePath)
                ->setAnswerSocketFilePath($clientSocketFilePath);

            $client = new Client($clientConfigDTO);
            $client->connectToSocket();

            while (true) {
                $userText = trim(fgets(STDIN));

                if ($userText === '') {
                    break;
                }

                $client->sendMessage($userText);
            }

        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}