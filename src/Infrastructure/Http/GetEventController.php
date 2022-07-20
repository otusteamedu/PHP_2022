<?php

namespace App\Infrastructure\Http;

use App\Application\UseCase\GetEventUseCase;
use App\Domain\Contract\GetEventDTOInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/event', methods: ['GET', 'HEAD'])]
class GetEventController extends AbstractController
{
    public function __construct(
        private GetEventUseCase $getEventUseCase
    ) {}


    public function __invoke(GetEventDTOInterface $dto): JsonResponse
    {
        $response = $this->getEventUseCase->getEvent($dto);

        return $this->json($response);
    }
}
