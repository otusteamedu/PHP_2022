<?php

declare(strict_types=1);

namespace DKozlov\Otus;

use Closure;
use DKozlov\Otus\Application\Builder\Interface\ProductBuilderInterface;
use DKozlov\Otus\Application\Factory\BurgerFactory;
use DKozlov\Otus\Application\Factory\ButerFactory;
use DKozlov\Otus\Application\Factory\HotDogFactory;
use DKozlov\Otus\Application\Factory\Interface\ProductFactoryInterface;
use DKozlov\Otus\Application\Factory\SandwichFactory;
use DKozlov\Otus\Application\Observer\Interface\ProductObserverInterface;
use DKozlov\Otus\Infrastructure\Http\Controller;

class Application
{
    private static ?Config $config = null;

    public function __construct()
    {
        self::$config = new Config();
    }

    public function run(): void
    {
        self::$config->setDepency(ProductFactoryInterface::class, $this->getProductFactory());

        $controller = new Controller();

        $controller->index(
            self::$config->depency(ProductBuilderInterface::class),
            self::$config->depency(ProductObserverInterface::class),
        );
    }

    private function getProductFactory(): Closure
    {
        return match ($_SERVER['REQUEST_URI']) {
            '/sandwich/' => static fn () => new SandwichFactory(),
            '/hot-dog/' => static fn () => new HotDogFactory(),
            '/buter/' => static fn () => new ButerFactory(),
            default => static fn () => new BurgerFactory()
        };
    }
}