<?php

namespace App\Controller;

use App\Service\OrderPayService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_default')]
    public function index(OrderPayService $orderPayService): Response
    {
        $orderPayService->index();

        return $this->json(['result' => 'ok']);
    }
}
