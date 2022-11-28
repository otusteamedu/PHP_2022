<?php

namespace Koptev\Hw6;

class SocketMessage
{
    public string $text;
    public int $bytes;
    public string $address;

    public static function instance(array $attributes): SocketMessage
    {
        $instance = new SocketMessage;

        foreach ($attributes as $key => $value) {
            $instance->$key = $value;
        }

        return $instance;
    }
}
