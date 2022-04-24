<?php


namespace Decole\Hw13\Core\Repositories;


use Decole\Hw13\Core\Dtos\EventAddDto;
use Decole\Hw13\Core\Kernel;
use JsonException;
use Predis\Client;
use Ramsey\Uuid\Uuid;

class RedisStorageRepository implements StorageRepositoryInterface
{
    public const KEY = 'event';

    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'scheme' => 'tcp',
            'host'   => 'redis',
            'port'   => 6379,
            'database' => 0
        ]);
    }

    /**
     * @throws JsonException
     */
    public function save(EventAddDto $dto): void
    {
        $uuid = Uuid::uuid4();
        $this->client->sadd(self::KEY, [$uuid]);
        $this->client->hset($uuid, 'event_name', $dto->eventType);
        $this->client->hset($uuid, 'priority', $dto->priority);
        $this->client->hset($uuid, 'condition', $dto->getCondition());
    }

    public function getByParams(array $condition): array
    {
        $list = $this->client->smembers(self::KEY);

        Kernel::dump($list);

        return [];
    }

    public function deleteAll(): void
    {
        return;
    }
}