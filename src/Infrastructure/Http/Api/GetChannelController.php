<?php

namespace App\Infrastructure\Http\Api;

use App\Domain\Entity\Channel;
use App\Infrastructure\Repository\ElasticChannelRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class GetChannelController
{
    public function __construct(
        private readonly ElasticChannelRepository $repository,
    ){}


    #[Route('/v1/channel/{id}', methods: ['GET'])]
    public function get(string $id): JsonResponse
    {
        $channel = $this->repository->getChannel($id);

        return new JsonResponse($channel?->toArray(), 200);
    }


    #[Route('/v1/channel', methods: ['GET'])]
    public function top(): JsonResponse
    {
        /** @var Channel[] $channels */
        $channels = $this->repository->getTop(10);

        return new JsonResponse(array_map(fn (Channel $channel) => $channel->toArray(), $channels), 200);
    }
}
