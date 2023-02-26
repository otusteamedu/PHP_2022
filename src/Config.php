<?php

namespace Dkozlov\Otus;

use Closure;
use DKozlov\Otus\Domain\Sender\SenderInterface;
use DKozlov\Otus\Exception\DepencyNotFoundException;
use DKozlov\Otus\Exception\RouteNotFoundException;
use DKozlov\Otus\Infrastructure\Http\BankController;
use DKozlov\Otus\Infrastructure\Http\DTO\RequestInterface;
use DKozlov\Otus\Infrastructure\Http\IndexController;
use DKozlov\Otus\Infrastructure\Queue\BankStatementQueue;
use DKozlov\Otus\Infrastructure\Sender\EmailSender;
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
            throw new DepencyNotFoundException('Required depency not found');
        }

        $depency = $this->depencies[$interface];

        if ($depency instanceof Closure) {
            $this->depencies[$interface] = $depency();
        }

        return $this->depencies[$interface];
    }

    public function setDepency(string $interface, Closure $depency): void
    {
        $this->depencies[$interface] = $depency;
    }

    protected function initDepencies(): void
    {
        $this->depencies[SenderInterface::class] = static fn () => new EmailSender();
        $this->depencies[BankStatementQueue::class] = fn () => new BankStatementQueue($this->depency(SenderInterface::class));
    }

    protected function initConfig(): void
    {
        $dotenv = new Dotenv();

        $dotenv->load('../.env');

        $this->config['views'] = $_SERVER['DOCUMENT_ROOT'] . '/../views';
        $this->config['AMQP_PORT'] = $_ENV['AMQP_PORT'];
        $this->config['RABBITMQ_HOST'] = $_ENV['RABBITMQ_HOST'];
        $this->config['RABBITMQ_USER'] = $_ENV['RABBITMQ_USER'];
        $this->config['RABBITMQ_PASSWORD'] = $_ENV['RABBITMQ_PASSWORD'];
    }

    protected function initRoutes(): void
    {
        $this->routes = [
            'GET' => [
                '/' => [IndexController::class, 'home']
            ],
            'POST' => [
                '/api/bank/statement' => [BankController::class, 'statement']
            ],
            'CLI' => [
                'bank-statement-consumer' => [BankStatementQueue::class, 'receive']
            ]
        ];
    }
}