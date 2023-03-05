<?php

declare(strict_types=1);

namespace DKozlov\Otus;

use DKozlov\Otus\Exception\DepencyNotFoundException;
use Dkozlov\Otus\Exception\RouteNotFoundException;
use DKozlov\Otus\Infrastructure\Http\DTO\Request;
use DKozlov\Otus\Infrastructure\Http\DTO\RequestInterface;
use DKozlov\Otus\Infrastructure\Http\DTO\Response;
use DKozlov\Otus\Infrastructure\Http\DTO\ResponseInterface;
use ReflectionClass;

class Application
{
    private static ?Config $config = null;

    public function __construct()
    {
        self::$config = new Config();
    }

    /**
     * @throws RouteNotFoundException
     * @throws \ReflectionException
     */
    public function run(): void
    {
        $request = $this->getRequest();
        $response = new Response();

        [$class, $method] = self::$config->route($request);

        $class = new ReflectionClass($class);

        $parameters = $class
            ->getConstructor()
            ->getParameters();

        $args = [];

        foreach ($parameters as $parameter) {
            $args[$parameter->getName()] = self::depency($parameter->getType()->getName());
        }

        $handler = $class->newInstanceArgs($args);
        $handler->$method($response, $request);

        $this->handleResponse($response, $request);
    }

    public static function config(string $name): mixed
    {
        return self::$config->config($name);
    }

    /**
     * @throws DepencyNotFoundException
     */
    public static function depency(string $interface): mixed
    {
        return self::$config->depency($interface);
    }

    private function handleResponse(ResponseInterface $response, RequestInterface $request): void
    {
        if ($request->method() !== 'CLI') {
            http_response_code($response->getCode());
        }

        echo $response->getBody();
    }

    private function getRequest(): RequestInterface
    {
        if (PHP_SAPI === 'cli') {
            $data = getopt('', ['command:']);

            return new Request($data, 'CLI', $data['command']);
        }

        $uri = explode('?', $_SERVER['REQUEST_URI']);
        $uri = $uri[0];

        $method = $_SERVER['REQUEST_METHOD'];

        $data = json_decode(file_get_contents('php://input'));

        if (!$data) {
            $data = [];
        }

        $data = array_merge($data, $_REQUEST);

        return new Request($data, $method, $uri);
    }
}