<?php

declare(strict_types=1);

namespace Nikolai\Php\Kernel;

use Nikolai\Php\ControllerResolver\ConsoleCommandControllerResolver;
use Nikolai\Php\ElasticSearchClient\ElasticSearchClientBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Kernel implements KernelInterface
{
    public function process(Request $request): ?Response
    {
        $argv = $request->server->get('argv');
        $controllerClass = (new ConsoleCommandControllerResolver($argv[1]))->resolve();

        $elasticSearchClient = ElasticSearchClientBuilder::create($request);
        $controller = new $controllerClass($elasticSearchClient);
        $controller($request);

        return null;
    }
}