<?php

namespace Dkozlov\Otus;

use Closure;
use Dkozlov\Otus\Application\Repository\Interface\RepositoryInterface;
use Dkozlov\Otus\Application\Repository\BookRepository;
use Dkozlov\Otus\Application\Storage\StorageInterface;
use Dkozlov\Otus\Exception\ConfigNotFoundException;
use Dkozlov\Otus\Exception\DepencyNotFoundException;
use Dkozlov\Otus\Infrastructure\Storage\ElasticSearchStorage;

class Config
{
    private array $data = [];

    private array $depencies = [];

    /**
     * @throws ConfigNotFoundException
     */
    public function __construct(string $path)
    {
        $this->load($path);
        $this->initDepencies();
    }

    /**
     * @param string $name
     * @return false|mixed
     */
    public function get(string $name): mixed
    {
        return $this->data[$name] ?? false;
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

    /**
     * @throws ConfigNotFoundException
     */
    protected function load(string $path): void
    {
        if (!file_exists($path)) {
            throw new ConfigNotFoundException("Could not find config by path: {$path}");
        }

        $this->data = parse_ini_file($path);
    }

    protected function initDepencies(): void
    {
        $this->depencies[StorageInterface::class] = static fn () => new ElasticSearchStorage();
        $this->depencies[RepositoryInterface::class] = fn () => new BookRepository(
            $this->depency(StorageInterface::class)
        );
    }
}