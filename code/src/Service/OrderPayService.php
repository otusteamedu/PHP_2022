<?php

declare(strict_types=1);

namespace App\Service;

use App\Requests\OrderRequest;
use Doctrine\ORM\EntityManagerInterface;

/**
 * OrderPayService
 */
class OrderPayService
{
    /**
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $em;

    private OrderRequest $orderRequest;

    public function __construct(EntityManagerInterface $entityManager, OrderRequest $orderRequest) {
        $this->em = $entityManager;
        $this->orderRequest = $orderRequest;
    }

    public function index(): void
    {
        $this->orderRequest->validate();
    }
}