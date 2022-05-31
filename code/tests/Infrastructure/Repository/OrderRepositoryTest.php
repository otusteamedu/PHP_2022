<?php

namespace App\Tests\Infrastructure\Repository;

use App\Domain\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class OrderRepositoryTest extends KernelTestCase
{
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testSetOrderIsPaid(): void
    {
        $order = $this->entityManager
            ->getRepository(Order::class)
            ->setOrderIsPaid(1234567890, 50);

        $this->assertTrue($order);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
