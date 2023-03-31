<?php

declare(strict_types=1);

namespace App\User\Application\Dto;

class UpdateUserResponse implements \JsonSerializable
{
    public $message;

    public function jsonSerialize(): mixed
    {
        $vars = get_object_vars($this);

        return $vars;
    }
}
