<?php

declare(strict_types=1);

namespace App\Chat\Service;

class Arr
{
    public static function randomValue(array $arr): mixed
    {
        return $arr[\array_rand($arr)];
    }
}