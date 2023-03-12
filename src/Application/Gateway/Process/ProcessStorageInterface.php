<?php

namespace App\Application\Gateway\Process;

use App\Domain\Entity\Process;
use App\Domain\Enum\ProcessStatus;

interface ProcessStorageInterface
{
    public function save(Process $process): void;

    public function getStatusById(string $id): ProcessStatus;

    public function updateStatusById(string $id, ProcessStatus $newStatus): void;
}