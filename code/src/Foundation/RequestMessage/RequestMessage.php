<?php

declare(strict_types=1);

namespace Nsavelev\Hw5\Foundation\RequestMessage;

use Nsavelev\Hw5\Foundation\RequestMessage\DTOs\MessageDTO;
use Nsavelev\Hw5\Foundation\RequestMessage\Interfaces\RequestMessageInterface;

class RequestMessage implements RequestMessageInterface
{
    /** @var object */
    private object $body;

    /**
     * @param MessageDTO $messageDto
     */
    public function __construct(MessageDTO $messageDto)
    {
        $this->body = $messageDto->getBody();
    }

    /**
     * @return object
     */
    public function getBody()
    {
        return $this->body;
    }
}