<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\Controller;

class DefaultController implements ControllerInterface
{
    public function __invoke($request)
    {
        echo 'Не найден контроллер для команды: ' . $request->server->get('argv')[1] . PHP_EOL;
    }
}