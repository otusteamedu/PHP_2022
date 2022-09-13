<?php

declare(strict_types=1);

namespace Nikolai\Php\Service;

class Dumper implements DumperInterface
{
    public function dump(string $header, $var): void
    {
        echo '<br>' . $header . ':<br><pre>';
        var_dump($var);
        echo '</pre>';
    }
}