<?php

declare(strict_types=1);

namespace Nikolai\Php\Controller;

use Symfony\Component\HttpFoundation\Request;

class DefaultController
{
    public function __invoke(Request $request)
    {
        echo 'Не найден контроллер для команды: ' . $request->server->get('argv')[1] . PHP_EOL;
    }
}