<?php

declare(strict_types=1);

namespace App\Infrastructure\Gateway\Process;

use App\Domain\Entity\Process;
use App\Domain\Enum\ProcessStatus;
use Predis\Client;
use App\Application\Gateway\Process\ProcessStorageInterface;

class RedisProcessStorage implements ProcessStorageInterface
{
    private const PROCESS_SET_PREFIX = 'process';
    public function __construct(private readonly Client $client)
    {
    }

    public function save(Process $process): void
    {
        $this->client->set(self::PROCESS_SET_PREFIX . $process->getId(), $process->getStatus()->value);
    }

    public function getStatusById(string $id): ProcessStatus
    {
        $status = $this->client->get(self::PROCESS_SET_PREFIX . $id);

        if (\is_null($status)) {
            return ProcessStatus::NOT_FOUND;
        }

        return ProcessStatus::from($status);
    }

    public function updateStatusById(string $id, ProcessStatus $newStatus): void
    {
        $this->client->set(self::PROCESS_SET_PREFIX . $id, $newStatus->value);
    }
}