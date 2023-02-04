<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw11;

use Nikcrazy37\Hw11\Dto\EntityDto;
use Nikcrazy37\Hw11\Exception\AppException;
use Nikcrazy37\Hw11\Exception\NotFoundClassException;
use Nikcrazy37\Hw11\Exception\NotFoundFileException;
use Nikcrazy37\Hw11\Exception\NotFoundMethodException;

class Router
{
    private const ROUTES_PATH = ROOT . "/config/routes.php";
    private const CONTROLLER_NAMESPACE = "Nikcrazy37\Hw11\Controller\\";
    private const REPOSITORY_NAMESPACE = "Nikcrazy37\Hw11\Repository\\";

    /**
     * @var array
     */
    private array $routes;
    /**
     * @var string
     */
    private string $uri;
    /**
     * @var mixed
     */
    private mixed $repositoryName;
    /**
     * @var string
     */
    private string $repositoryObjectPath;

    /**
     * @throws NotFoundFileException
     * @throws AppException
     */
    public function __construct()
    {
        $this->includeRoutes();
        $this->uri = $this->getUri();
        $this->repositoryName = Config::getOption("REPOSITORY");
        $this->repositoryObjectPath = $this->buildRepositoryPath();
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
                $repository = new $this->repositoryObjectPath(
                    new EntityDto(
                        $entityName,
                        $this->getEntityMultyName($entityName)
                    )
                );

                $controllerName = ucfirst($entityName) . 'Controller';
                $actionName = array_shift($segments);
                $controllerObjectPath = self::CONTROLLER_NAMESPACE . $controllerName;

                if (!class_exists($controllerObjectPath)) {
                    throw new NotFoundClassException($controllerObjectPath);
                }

                if (!method_exists($controllerObjectPath, $actionName)) {
                    throw new NotFoundMethodException($actionName);
                }

                $controllerObject = new $controllerObjectPath($repository);
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

    /**
     * @param $entityName
     * @return string
     */
    private function getEntityMultyName($entityName): string
    {
        return $entityName . "s";
    }

    /**
     * @return string
     */
    private function buildRepositoryPath(): string
    {
        return self::REPOSITORY_NAMESPACE . $this->repositoryName . "\\" . $this->repositoryName;
    }
}