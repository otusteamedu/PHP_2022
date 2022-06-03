<?php

namespace App\Infrastructure\Controller;

use App\Application\Service\ReportDataService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="app_default")
     */
    public function index(ReportDataService $orderPayService, EntityManagerInterface $entityManager): JsonResponse
    {
        return $orderPayService->index();
    }
}
