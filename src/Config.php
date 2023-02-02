<?php

namespace Dkozlov\Otus;

use Closure;
use DKozlov\Otus\Application\Builder\Interface\ProductBuilderInterface;
use DKozlov\Otus\Application\Builder\ProductBuilder;
use DKozlov\Otus\Domain\Factory\Interface\IngredientFactoryInterface;
use DKozlov\Otus\Application\Factory\Interface\ProductFactoryInterface;
use DKozlov\Otus\Application\Observer\Interface\ProductObserverInterface;
use DKozlov\Otus\Application\Observer\ProductObserver;
use DKozlov\Otus\Domain\Factory\IngredientFactory;
use Dkozlov\Otus\Exception\DepencyNotFoundException;

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
        $this->setDepency(IngredientFactoryInterface::class, static fn () => new IngredientFactory());
        $this->setDepency(ProductBuilderInterface::class, fn () => new ProductBuilder(
            $this->depency(ProductFactoryInterface::class),
            $this->depency(ProductObserverInterface::class),
            $this->depency(IngredientFactoryInterface::class)
        ));
    }
}