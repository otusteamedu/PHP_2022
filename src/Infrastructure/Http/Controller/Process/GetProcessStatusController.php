<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller\Process;

use App\Application\Queue\BusInterface;
use App\Application\UseCase\Process\ProcessStatusManager;
use App\Domain\Enum\ProcessStatus;
use Bitty\Http\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Контроллер для проверки статуса каких-то долгих процессов.
 */
class GetProcessStatusController
{
    public function __construct(private readonly ProcessStatusManager $statusManager)
    {
    }

    public function __invoke(ServerRequestInterface $request): JsonResponse
    {
        $processId = $request->getAttribute('id');

        $status = $this->statusManager->getStatusById($processId);

        return new JsonResponse([
            'processId' => $processId,
            'status' => $status->value,
        ]);
    }
}