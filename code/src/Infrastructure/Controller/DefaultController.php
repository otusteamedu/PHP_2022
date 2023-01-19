<?php

declare(strict_types=1);

namespace Cookapp\Php\Infrastructure\Controller;

/**
 * Default controller
 */
class DefaultController implements ControllerInterface
{
    /**
     * @param $request
     * @return mixed|void
     */
    public function __invoke($request)
    {
        $consoleCommand = $request->server->get('argv')[1] ?? '';
        echo 'Controller not found for command: ' . $consoleCommand . PHP_EOL;
    }
}
