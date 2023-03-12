<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller\Process;

use App\Application\Queue\BusInterface;
use App\Domain\Enum\ProcessStatus;
use Bitty\Http\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Контроллер для проверки статуса каких-то долгих процессов.
 */
class GetProcessStatusController
{
    public function __invoke(ServerRequestInterface $request): JsonResponse
    {
        $processId = \uniqid('process', true);

        // ... отправляем процесс на обработку, сохраняем в редисе

        return new JsonResponse([
            'processId' => $processId,
            'status' => ProcessStatus::CREATED->name,
        ]);
    }
}