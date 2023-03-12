<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller\Process;

use App\Application\Queue\BusInterface;
use App\Domain\Enum\ProcessStatus;
use Bitty\Http\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use App\Application\UseCase\Process\ProcessCreator;

/**
 * Контроллер для создания и проверки статуса каких-то долгих процессов. Поэтому над названием не заморачивался - process)
 */
class CreateProcessController
{
    public function __construct(private readonly ProcessCreator $processCreator)
    {
    }

    public function __invoke(ServerRequestInterface $request): JsonResponse
    {
        $process = $this->processCreator->create();

        return new JsonResponse([
            'processId' => $process->getId(),
            'status' => $process->getStatus()->name,
        ]);
    }
}