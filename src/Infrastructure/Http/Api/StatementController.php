<?php

namespace App\Infrastructure\Http\Api;

use App\Application\UseCase\Statement\CreateUseCase;
use App\Application\UseCase\Statement\ReadUseCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class StatementController
{
    public function __construct(
        private readonly CreateUseCase $createUseCase,
        private readonly ReadUseCase $readUseCase
    ) {}


    #[Route('/v1/statement', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $statement = $this->createUseCase->create();

        return new JsonResponse([
            'id' => $statement->getId(),
            'status' => $statement->getStatus()->value,
        ], 201);
    }


    #[Route('/v1/statement/{id}', methods: ['GET'])]
    public function read(string $id): JsonResponse
    {
        $statement = $this->readUseCase->get($id);

        return new JsonResponse([
            'id' => $statement->getId(),
            'status' => $statement->getStatus()->value,
        ], 200);
    }
}
