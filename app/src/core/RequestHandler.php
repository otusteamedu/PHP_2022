<?php

namespace nka\otus\core;

use DI\Container;
use FastRoute\Dispatcher;
use nka\otus\core\exceptions\ApplicationException;
use nka\otus\core\exceptions\MethodNotAllowedException;
use nka\otus\core\exceptions\RouteNotFoundException;

class RequestHandler
{
    public function __construct(
        public Dispatcher $dispatcher,
        public Request $request
    )
    {
    }

    /**
     * @throws \DI\DependencyException
     * @throws ApplicationException
     * @throws \DI\NotFoundException
     */
    public function handle(Container $container, array $pathConfig = [])
    {
        $result = $this->dispatcher->dispatch(
            $this->request->getMethod(),
            $this->request->getUri()
        );

        return match ($result[0]) {
            Dispatcher::FOUND => $container->call(
                function (Container $container) use ($result, $pathConfig) {
                    /**
                     * @var AbstractController $controller
                     */
                    $controller = $container->get($result[1]);
                    $controller->loadParams($pathConfig);
                    return $controller();
                }
            ),
            Dispatcher::NOT_FOUND => throw new RouteNotFoundException(),
            Dispatcher::METHOD_NOT_ALLOWED => throw new MethodNotAllowedException()
        };
    }
}