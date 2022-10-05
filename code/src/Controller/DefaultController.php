<?php

declare(strict_types=1);

namespace Nikolai\Php\Controller;

class DefaultController
{
    public function __invoke()
    {
        fwrite(STDOUT, 'Не найден контроллер для команды: ' . $_SERVER['argv'][1] . PHP_EOL);
    }
}