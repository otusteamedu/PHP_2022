<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Domain\Entity\Order;
use App\Infrastructure\Requests\OrderRequest;
use App\Infrastructure\Response\ResponseFailed;
use App\Infrastructure\Response\ResponseSuccess;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

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

    public function index(): JsonResponse
    {
        $this->orderRequest->validate();

        $result = $this->em->getRepository(Order::class)->setOrderIsPaid($this->orderRequest->getOrderNumber(), $this->orderRequest->getSum());

        if (!$result) {
            return (new ResponseFailed(['db' => 'data is not updated']))->send();
        }

        return (new ResponseSuccess())->send();
    }

}