<?php

declare(strict_types=1);

namespace App\Application\UseCase\Process;

use App\Application\Gateway\Process\ProcessStorageInterface;
use App\Domain\Entity\Process;

class ProcessCreator
{
    public function __construct(private readonly ProcessStorageInterface $processStorage)
    {
    }

    public function create(): Process
    {
        $process = new Process();

        $this->processStorage->save($process);

        return $process;
    }
}