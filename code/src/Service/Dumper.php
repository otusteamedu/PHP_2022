<?php

declare(strict_types=1);

namespace Nikolai\Php\Service;

class Dumper implements DumperInterface
{
    public function dump(string $header, ?array $var = []): void
    {
        echo $header . PHP_EOL;
        if ($var) {
            var_dump($var);
        }
    }
}