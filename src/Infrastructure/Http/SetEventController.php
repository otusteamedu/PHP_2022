<?php

namespace App\Infrastructure\Http;

use App\Application\UseCase\GetEventUseCase;
use App\Application\UseCase\SetEventUseCase;
use App\Domain\Contract\GetEventDTOInterface;
use App\Domain\Contract\SetEventDTOInterface;
use App\Domain\Model\Event;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/event', methods: ['POST'])]
class SetEventController extends AbstractController
{
    public function __construct(
        private SetEventUseCase $setEventUseCase
    ) {}


    public function __invoke(SetEventDTOInterface $dto): JsonResponse
    {
        $response = array_map(fn (Event $event) => $event->toArray(), $this->setEventUseCase->setEvent($dto));

        return $this->json($response);
    }
}
