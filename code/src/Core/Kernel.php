<?php
declare(strict_types=1);


namespace Decole\Hw13\Core;


use Dotenv\Dotenv;
use Klein\Klein;

final class Kernel
{
    private Klein $router;

    private array $rotes = [];

    public static function getConfigParam(string $param): ?string
    {
        return $_ENV[$param];
    }

    public static function dump(mixed $value): void
    {
        var_dump($value);
        exit();
    }
}