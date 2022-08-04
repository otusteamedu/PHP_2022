<?php

namespace App\Tests;

use App\ProductFactory\BurgerFactory;
use App\Strategy\CheeseBurgerStrategy;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AllIncludedTest extends KernelTestCase
{
    private $container;

    protected function setUp(): void
    {
        parent::setUp();

        self::bootKernel();
        $this->container = self::$kernel->getContainer();
    }


    public function testException(): void
    {
        $burgerFactory = $this->container->get(BurgerFactory::class);

        $this->expectExceptionMessage('Strategy is not available for this factory');

        $burgerFactory->makeProduct();
    }

    public function testCheeseBurgerStrategy(): void
    {
        $strategy = $this->container->get(CheeseBurgerStrategy::class);
        $burgerFactory = $this->container->get(BurgerFactory::class);
        $burgerFactory->setStrategy($strategy);

        $product = $burgerFactory->makeProduct();
        $this->assertEquals([
            'булка',
            'котлета',
            'сыр',
            'булка',
        ], $product->getIngredients());
    }
}
