<?php

namespace ValueObject;

class Argument
{
    public const SERVER = 'server';
    public const CLIENT = 'client';

    public function isValid($type): bool
    {
        return $type === self::SERVER || $type === self::CLIENT;
    }
}
