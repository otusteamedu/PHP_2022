<?php

namespace AKhakhanova\Hw3\Service;

use Stringy\Stringy;

class StringService
{
    public function convertString(string $s): string
    {
        $result = Stringy::create($s)
                         ->collapseWhitespace()
                         ->swapCase();

        return (string)$result;
    }
}
