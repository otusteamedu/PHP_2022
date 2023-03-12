<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller\Process;

use App\Application\Queue\BusInterface;
use App\Domain\Enum\ProcessStatus;
use Bitty\Http\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Контроллер для создания и проверки статуса каких-то долгих процессов. Поэтому над названием не заморачивался - process)
 */
class CreateProcessController
{
    public function create(ServerRequestInterface $request): JsonResponse
    {
        $processId = \uniqid('process', true);

        // ... отправляем процесс на обработку, сохраняем в редисе

        return new JsonResponse([
            'processId' => $processId,
            'status' => ProcessStatus::CREATED->name,
        ]);
    }
}