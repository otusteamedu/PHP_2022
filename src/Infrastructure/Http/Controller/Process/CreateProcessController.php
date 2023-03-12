<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller\Process;

use App\Application\Queue\BusInterface;
use App\Domain\Enum\ProcessStatus;
use App\Infrastructure\Queue\Process\OperateProcessMessage;
use Bitty\Http\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use App\Application\UseCase\Process\ProcessCreator;

/**
 * Контроллер для создания и проверки статуса каких-то долгих процессов. Поэтому над названием не заморачивался - process)
 */
class CreateProcessController
{
    public function __construct(
        private readonly ProcessCreator $processCreator,
        private readonly BusInterface $bus
    )
    {
    }

    public function __invoke(ServerRequestInterface $request): JsonResponse
    {
        $process = $this->processCreator->create();

        $this->bus->dispatch(new OperateProcessMessage($process));

        return new JsonResponse([
            'processId' => $process->getId(),
            'status' => $process->getStatus()->name,
        ], 201);
    }
}