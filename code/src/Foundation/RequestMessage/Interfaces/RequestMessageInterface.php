<?php

namespace Nsavelev\Hw5\Foundation\RequestMessage\Interfaces;

use Nsavelev\Hw5\Foundation\RequestMessage\DTOs\MessageDTO;

interface RequestMessageInterface
{
    /**
     * @param MessageDTO $messageDTO
     */
    public function __construct(MessageDTO $messageDTO);

    public function getBody();
}