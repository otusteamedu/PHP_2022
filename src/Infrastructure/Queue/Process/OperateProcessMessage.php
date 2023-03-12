<?php

declare(strict_types=1);

namespace App\Infrastructure\Queue\Process;

use App\Application\Queue\MessageInterface;
use App\Domain\Entity\Process;

class OperateProcessMessage implements MessageInterface
{
    public function __construct(private readonly Process $process)
    {
    }

    public function getProcess(): Process
    {
        return $this->process;
    }

    public function getHandlerClass(): string
    {
        return OperateProcessHandler::class;
    }
}