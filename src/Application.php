<?php

declare(strict_types=1);

namespace Nikolai\Php;

use NikolayTim\Dumper\Dumper;

class Application implements ApplicationInterface
{
    public function run(): void
    {
        $someArray = [
            'a' => 1,
            'b' => 2,
            'c' => 3,
        ];

        $dumper = new Dumper();
        $dumper->dump($someArray);
    }
}