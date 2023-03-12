<?php

declare(strict_types=1);

namespace App\Infrastructure\Queue\Process;

use App\Application\Queue\HandlerInterface;
use App\Application\UseCase\Process\ProcessStatusManager;
use App\Domain\Enum\ProcessStatus;

/**
 * Долгий обработчик долгого процесса.
 */
class OperateProcessHandler implements HandlerInterface
{
    public function __construct(private readonly ProcessStatusManager $processStatusManager)
    {
    }

    /**
     * Долго обрабатывает долгий процесс
     */
    public function handle(OperateProcessMessage $message): void
    {
        $process = $message->getProcess();
        $this->processStatusManager->updateStatus($process->getId(), ProcessStatus::PROCESSING);

        // дооооолгая обработка
        \sleep(\random_int(5, 10));

        $this->processStatusManager->updateStatus($process->getId(), ProcessStatus::FINISHED);
    }
}