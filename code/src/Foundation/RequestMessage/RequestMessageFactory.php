<?php

declare(strict_types=1);

namespace Nsavelev\Hw5\Foundation\RequestMessage;

use Nsavelev\Hw5\Foundation\RequestMessage\DTOs\MessageDTO;

class RequestMessageFactory
{
    /**
     * @param MessageDTO $messageDTO
     * @return RequestMessage
     */
    public function createRequestMessage(MessageDTO $messageDTO): RequestMessage
    {
        return new RequestMessage($messageDTO);
    }
}