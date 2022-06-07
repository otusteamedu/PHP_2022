<?php

namespace App\Infrastructure\Controller;

use App\Application\Service\ReportDataService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    private ReportDataService $orderPayService;

    public function __construct(ReportDataService $orderPayService)
    {
        $this->orderPayService = $orderPayService;
    }

    /**
     * @Route("/v1/report/create")
     */
    public function create(): JsonResponse
    {
        return $this->orderPayService->create();
    }

    /**
     * @Route("/v1/report/update/{id}")
     */
    public function update(string $id): JsonResponse
    {
        return $this->orderPayService->update($id);
    }

    /**
     * @Route("/v1/report/delete/{id}")
     */
    public function delete(string $id): JsonResponse
    {
        return $this->orderPayService->delete($id);
    }
}
