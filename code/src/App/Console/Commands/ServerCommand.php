<?php

declare(strict_types=1);

namespace Nsavelev\Hw6\App\Console\Commands;

use Nsavelev\Hw6\App\Interfaces\CommandInterface;
use Nsavelev\Hw6\Services\Config\Config;
use Nsavelev\Hw6\Services\Server\DTOs\ServerConfigDTO;
use Nsavelev\Hw6\Services\Server\Handlers\BaseMessageHandler;
use Nsavelev\Hw6\Services\Server\Server;

class ServerCommand implements CommandInterface
{
    public function handle(): void
    {
        $config = Config::getInstance();
        $serverSocketFilePath = $config->get('app.server_socket_filename_with_path');
        $clientSocketFilePath = $config->get('app.client_socket_filename_with_path');

        $serverConfigDTO = new ServerConfigDTO($serverSocketFilePath, $clientSocketFilePath);

        $baseMessageHandler = new BaseMessageHandler();
        Server::create($serverConfigDTO)
            ->listen($baseMessageHandler);
    }
}