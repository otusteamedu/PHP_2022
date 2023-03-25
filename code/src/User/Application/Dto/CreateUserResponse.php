<?php

declare(strict_types=1);

namespace Kogarkov\Es\User\Application\Dto;

class CreateUserResponse implements \JsonSerializable
{
    public $id;
    public $message;

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }
}
