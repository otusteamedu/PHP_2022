<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Enum\ProcessStatus;

class Process
{
    private string $id;

    private ProcessStatus $status;

    public function __construct()
    {
        $this->id = \uniqid('process', true);
        $this->status = ProcessStatus::CREATED;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getStatus(): ProcessStatus
    {
        return $this->status;
    }

    public function changeStatus(ProcessStatus $status): void
    {
        $this->status = $status;
    }
}