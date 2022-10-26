<?php

namespace Nsavelev\Hw6\Services\Server\Interfaces;

use Nsavelev\Hw6\Services\Server\DTOs\BaseMessageDTO;

interface MessageHandlerInterface
{
    /**
     * @param BaseMessageDTO $baseMessageDto
     * @return void
     */
    public function handle(BaseMessageDTO $baseMessageDto): void;
}