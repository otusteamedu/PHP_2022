<?php

declare(strict_types=1);

namespace App\Application\UseCase\Process;

use App\Application\Gateway\Process\ProcessStorageInterface;
use App\Domain\Enum\ProcessStatus;

/**
 * Менеджер для управления статусами процессов. Сейчас в этой прослойке особого смысла нет, можно и ProcessStorage
 * использовать. Но потом, возможно, добавится дополнительная логика, например логирование смены статуса или ведение
 * истории статусов. В таком случае использовать единый менеджер для управления статусами станет удобно
 */
class ProcessStatusManager
{
    public function __construct(private readonly ProcessStorageInterface $storage)
    {
    }

    public function getStatusById(string $id): ProcessStatus
    {
        return $this->storage->getStatusById($id);
    }

    public function updateStatus(string $id, ProcessStatus $newStatus): void
    {
        $this->storage->updateStatusById($id, $newStatus);
    }
}