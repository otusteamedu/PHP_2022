<?php

declare(strict_types=1);

namespace Domain\Contracts\Repository;

interface ApiTaskRepositoryInterface
{
    /**
     * @param string $uuid
     * @return array
     */
    public function getApiTaskByUuid(string $uuid): array;

    /**
     * @return string
     */
    public function createApiTask(): string;

    /**
     * @param string $uuid
     * @param array $data_for_update
     * @return void
     */
    public function updateApiTask(string $uuid, array $data_for_update): void;
}
