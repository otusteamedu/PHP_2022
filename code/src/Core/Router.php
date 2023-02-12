<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw12\Core;

use Nikcrazy37\Hw12\Core\Exception\AppException;
use Nikcrazy37\Hw12\Core\Exception\NotFoundFileException;
use Nikcrazy37\Hw12\Core\Exception\NotFoundClassException;
use Nikcrazy37\Hw12\Core\Exception\NotFoundMethodException;

class Router
{
    private const ROUTES_PATH = ROOT . "/config/routes.php";
    private const CONTROLLER_NAMESPACE = "Nikcrazy37\Hw12\Controller\\";

    /**
     * @var array
     */
    private array $routes;
    /**
     * @var string
     */
    private string $uri;

    /**
     * @throws NotFoundFileException
     * @throws AppException
     */
    public function __construct()
    {
        $this->includeRoutes();
        $this->uri = $this->getUri();
    }

    /**
     * @return void
     * @throws AppException
     */
    public function execute(): void
    {
        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~$uriPattern~", $this->uri)) {
                $segments = explode('/', $path);

                $entityName = array_shift($segments);

                $controllerName = ucfirst($entityName) . 'Controller';
                $actionName = array_shift($segments);
                $controllerObjectPath = self::CONTROLLER_NAMESPACE . $controllerName;

                if (!class_exists($controllerObjectPath)) {
                    throw new NotFoundClassException($controllerObjectPath);
                }

                if (!method_exists($controllerObjectPath, $actionName)) {
                    throw new NotFoundMethodException($actionName);
                }

                $controllerObject = new $controllerObjectPath();
                $result = $controllerObject->$actionName();

                if ($result != null) {
                    break;
                }
            }
        }
    }

    /**
     * @return void
     * @throws NotFoundFileException
     */
    private function includeRoutes(): void
    {
        if (!file_exists(self::ROUTES_PATH)) {
            throw new NotFoundFileException(self::ROUTES_PATH);
        }

        $this->routes = include(self::ROUTES_PATH);
    }

    /**
     * @return string
     * @throws AppException
     */
    private function getUri(): string
    {
        if (empty($_SERVER['REQUEST_URI'])) {
            throw new AppException("Uncaught uri error!");
        }

        return trim($_SERVER['REQUEST_URI'], '/');
    }
}