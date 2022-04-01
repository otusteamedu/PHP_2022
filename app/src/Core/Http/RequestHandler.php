<?php

namespace Nka\Otus\Core\Http;

use DI\Container;
use FastRoute\Dispatcher;
use Nka\Otus\Core\AbstractController;
use Nka\Otus\Core\Config;
use Nka\Otus\Core\Exceptions\ApplicationException;
use Nka\Otus\Core\Exceptions\MethodNotAllowedException;
use Nka\Otus\Core\Exceptions\RouteNotFoundException;

class RequestHandler
{
    public function __construct(
        public Dispatcher $dispatcher,
        public Request $request,
        public Config $config
    )
    {
    }

    public function handle(Container $container)
    {
        $result = $this->dispatcher->dispatch(
            $this->request->getMethod(),
            $this->request->getUri()
        );

        return match ($result[0]) {
            Dispatcher::FOUND => $container->call(
                function (Container $container) use ($result) {
                    /**
                     * @var AbstractController $controller
                     */
                    $controller = $container->get($result[1]);
                    $controller->setConfig($this->config);
                    return $controller();
                }
            ),
            Dispatcher::NOT_FOUND => throw new RouteNotFoundException(),
            Dispatcher::METHOD_NOT_ALLOWED => throw new MethodNotAllowedException()
        };
    }
}