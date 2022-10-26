<?php

namespace Nsavelev\Hw6\Services\Server\Interfaces;

use Nsavelev\Hw6\Services\Server\DTOs\ServerConfigDTO;

interface ServerInterface
{
    /**
     * @param ServerConfigDTO $serverConfigDTO
     * @return self
     */
    public static function create(ServerConfigDTO $serverConfigDTO);

    /**
     * @param MessageHandlerInterface $messageHandlerInterface
     * @return void
     */
    public function listen(MessageHandlerInterface $messageHandlerInterface): void;
}