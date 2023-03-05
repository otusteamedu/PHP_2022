<?php

namespace DKozlov\Otus;

use Closure;
use DKozlov\Otus\Application\Operation\OperationIdentityMap;
use DKozlov\Otus\Application\Operation\OperationMapper;
use DKozlov\Otus\Domain\Operation\OperationMapperInterface;
use DKozlov\Otus\Domain\Storage\StorageInterface;
use DKozlov\Otus\Exception\DepencyNotFoundException;
use DKozlov\Otus\Exception\RouteNotFoundException;
use DKozlov\Otus\Infrastructure\Queue\Operation\FindOperationQueue;
use DKozlov\Otus\Infrastructure\Queue\Operation\RemoveOperationQueue;
use DKozlov\Otus\Infrastructure\Storage\Storage;
use DKozlov\Otus\Infrastructure\Http\OperationController;
use DKozlov\Otus\Infrastructure\Http\DTO\RequestInterface;
use DKozlov\Otus\Infrastructure\Queue\Operation\CreateOperationQueue;
use Symfony\Component\Dotenv\Dotenv;

class Config
{
    private array $config = [];

    private array $depencies = [];

    private array $routes = [];

    public function __construct()
    {
        $this->initConfig();
        $this->initDepencies();
        $this->initRoutes();
    }

    /**
     * @throws RouteNotFoundException
     */
    public function route(RequestInterface $request): array
    {
        $route = $this->routes[$request->method()][$request->uri()] ?? null;

        if (!$route) {
            throw new RouteNotFoundException("Route {$request->uri()} with method {$request->method()} not found");
        }

        return $route;
    }

    public function config(string $name): mixed
    {
        return $this->config[$name] ?? null;
    }

    /**
     * @throws DepencyNotFoundException
     */
    public function depency(string $interface): mixed
    {
        if (!isset($this->depencies[$interface])) {
            throw new DepencyNotFoundException("Depency for $interface not found");
        }

        $depency = $this->depencies[$interface];

        if ($depency instanceof Closure) {
            $this->depencies[$interface] = $depency();
        }

        return $this->depencies[$interface];
    }

    protected function initDepencies(): void
    {
        $this->depencies[StorageInterface::class] = static fn () => new Storage();

        $this->depencies[OperationIdentityMap::class] = static fn () => new OperationIdentityMap();

        $this->depencies[OperationMapperInterface::class] = fn () => new OperationMapper(
            $this->depency(StorageInterface::class),
            $this->depency(OperationIdentityMap::class)
        );

        $this->depencies[CreateOperationQueue::class] = fn () => new CreateOperationQueue(
            $this->depency(OperationMapperInterface::class)
        );
        $this->depencies[FindOperationQueue::class] = fn () => new FindOperationQueue(
            $this->depency(OperationMapperInterface::class)
        );
        $this->depencies[RemoveOperationQueue::class] = fn () => new RemoveOperationQueue(
            $this->depency(OperationMapperInterface::class)
        );
    }

    protected function initConfig(): void
    {
        $dotenv = new Dotenv();

        $dotenv->load('../.env');

        $this->config['views'] = $_SERVER['DOCUMENT_ROOT'] . '/../views';

        $this->config['DB_PORT'] = $_ENV['FORWARD_DB_PORT'];
        $this->config['DB_HOST'] = $_ENV['DB_HOST'];
        $this->config['DB_NAME'] = $_ENV['DB_NAME'];
        $this->config['DB_USERNAME'] = $_ENV['DB_USERNAME'];
        $this->config['DB_PASSWORD'] = $_ENV['DB_PASSWORD'];

        $this->config['AMQP_PORT'] = $_ENV['AMQP_PORT'];
        $this->config['RABBITMQ_HOST'] = $_ENV['RABBITMQ_HOST'];
        $this->config['RABBITMQ_USER'] = $_ENV['RABBITMQ_USER'];
        $this->config['RABBITMQ_PASSWORD'] = $_ENV['RABBITMQ_PASSWORD'];
    }

    protected function initRoutes(): void
    {
        $this->routes = [
            'POST' => [
                '/api/v1/operation/create' => [OperationController::class, 'createOperation']
            ],
            'GET' => [
                '/api/v1/operation/find' => [OperationController::class, 'findOperation']
            ],
            'DELETE' => [
                '/api/v1/operation/remove' => [OperationController::class, 'removeOperation']
            ],
            'CLI' => [
                'create-operation-consumer' => [CreateOperationQueue::class, 'receive'],
                'find-operation-consumer' => [FindOperationQueue::class, 'receive'],
                'remove-operation-consumer' => [RemoveOperationQueue::class, 'receive']
            ]
        ];
    }
}