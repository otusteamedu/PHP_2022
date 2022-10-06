<?php

declare(strict_types=1);

namespace Nikolai\Php\Controller;

use Symfony\Component\HttpFoundation\Request;

class DefaultController extends AbstructController
{
    public function __invoke(Request $request)
    {
        $this->dumper->dump('Не найден контроллер для команды: ' . $request->server->get('argv')[1]);
    }
}