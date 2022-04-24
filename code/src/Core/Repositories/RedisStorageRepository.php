<?php


namespace Decole\Hw13\Core\Repositories;


use Decole\Hw13\Core\Dtos\EventAddDto;
use Decole\Hw13\Core\Dtos\EventSearchedContext;
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
        $result = [];
        $list = $this->client->smembers(self::KEY);

        foreach ($list as $event) {
            $eventCondition = $this->client->hget($event, 'condition');
            $eventConditionArray = json_decode($eventCondition, true);

            if ($this->isConditionExist($eventConditionArray, $condition)) {
                $priority = $this->client->hget($event, 'priority');

                $result[$priority][$event] = new EventSearchedContext(
                    name: $this->client->hget($event, 'event_name'),
                    priority: $priority,
                    condition: $eventConditionArray,
                );
            }
        }

        return $result;
    }

    public function deleteAll(): void
    {
        $this->client->flushall();
    }

    private function isConditionExist(array $eventConditionArray, array $queryCondition): bool
    {
        foreach ($queryCondition as $condition => $value) {
            if (array_key_exists($condition, $eventConditionArray) && $eventConditionArray[$condition] == $value) {
                return true;
            }
        }

        return false;
    }
}