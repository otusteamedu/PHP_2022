<?php

declare(strict_types=1);

namespace Nsavelev\Hw5\Foundation\RequestMessage\DTOs;

class MessageDTO
{
    /** @var object */
    private object $body;

    /**
     * @param object $body
     * @return MessageDTO
     */
    public function setBody(object $body): MessageDTO
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return object
     */
    public function getBody(): object
    {
        return $this->body;
    }
}