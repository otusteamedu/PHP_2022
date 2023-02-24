<?php

declare(strict_types=1);

namespace VeraAdzhieva\Hw10\Service;

class InputParams
{
    private const PARAMS = [
        "title:",
        "category::",
        "price::"
    ];

    public function __construct()
    {
        return getopt('', self::PARAMS);
    }
}