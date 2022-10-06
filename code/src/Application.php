<?php

declare(strict_types=1);

namespace Nikolai\Php;

use Nikolai\Php\Configuration\ConfigurationLoader;
use Nikolai\Php\ControllerResolver\ConsoleCommandControllerResolver;
use Nikolai\Php\ElasticSearchClient\ElasticSearchClientBuilder;
use Symfony\Component\HttpFoundation\Request;

class Application implements ApplicationInterface
{
    public function __construct()
    {
        (new ConfigurationLoader())->load();
    }

    public function run(): void
    {
        $request = Request::createFromGlobals();
        $elasticSearchClient = ElasticSearchClientBuilder::create($request);
        $argv = $request->server->get('argv');

        $controllerClass = (new ConsoleCommandControllerResolver($argv[1]))->resolve();
        $controller = new $controllerClass($elasticSearchClient);
        $controller($request);
    }
}