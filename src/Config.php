<?php

namespace Dkozlov\Otus;

use Closure;
use DKozlov\Otus\Application\Builder\Interface\ProductBuilderInterface;
use DKozlov\Otus\Application\Builder\ProductBuilder;
use DKozlov\Otus\Application\Factory\Interface\ProductFactoryInterface;
use DKozlov\Otus\Application\Observer\Interface\ProductObserverInterface;
use DKozlov\Otus\Application\Observer\ProductObserver;
use Dkozlov\Otus\Application\Repository\Interface\RepositoryInterface;
use Dkozlov\Otus\Application\Repository\BookRepository;
use Dkozlov\Otus\Application\Storage\StorageInterface;
use Dkozlov\Otus\Exception\ConfigNotFoundException;
use Dkozlov\Otus\Exception\DepencyNotFoundException;
use Dkozlov\Otus\Infrastructure\Storage\ElasticSearchStorage;

class Config
{
    private array $depencies = [];

    public function __construct()
    {
        $this->initDepencies();
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
        $this->setDepency(ProductObserverInterface::class, static fn () => new ProductObserver());
        $this->setDepency(ProductBuilderInterface::class, fn () => new ProductBuilder(
            $this->depency(ProductFactoryInterface::class),
            $this->depency(ProductObserverInterface::class)
        ));
    }
}