<?php

declare(strict_types=1);

namespace Models;

use Ramsey\Uuid\Uuid;
use Carbon\CarbonImmutable;
use Domain\Contracts\Repository\ApiTaskRepositoryInterface;

final class ApiTasks extends Model implements ApiTaskRepositoryInterface
{
    protected $table = 'api_tasks';

    /**
     * @param string $uuid
     * @return array
     */
    public function getApiTaskByUuid(string $uuid): array
    {
        db()->autoConnect();

        return db()
            ->select(table: $this->table)
            ->where(condition: 'uuid', comparator: $uuid)
            ->get();
    }

    /**
     * @return string
     */
    public function createApiTask(): string
    {
        db()->autoConnect();

        $uuid = Uuid::uuid4();

        db()
            ->insert($this->table)
            ->params(
                params: [
                    'uuid' => $uuid,
                    'status' => 'PENDING',
                    'result' => '',
                    'created_at' => CarbonImmutable::now(),
                    'updated_at' => CarbonImmutable::now(),
                ]
            )
            ->execute();

        return $uuid->toString();
    }

    /**
     * @param string $uuid
     * @param array $data_for_update
     * @return void
     */
    public function updateApiTask(string $uuid, array $data_for_update): void
    {
        db()->autoConnect();

        db()
            ->update(table: $this->table)
            ->params(params: $data_for_update)
            ->where(condition: 'uuid', comparator: $uuid)
            ->execute();
    }
}
