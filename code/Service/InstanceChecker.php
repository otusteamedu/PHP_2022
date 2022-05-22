<?php

declare(strict_types=1);

namespace App\Service;

class InstanceChecker
{
    public static function addHeader(): void
    {
        header("Instance: ".$_SERVER['HOSTNAME']);
    }
}