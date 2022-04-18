<?php


namespace Decole\Hw13\Core\Repositories;


use Decole\Hw13\Core\Dtos\EventAddDto;
use Predis\Client;

class RedisStorageRepository implements StorageRepositoryInterface
{
    private Client $client;

    public function __construct()
    {
        $client = new Client([
            'scheme' => 'tcp',
            'host'   => '10.0.0.1',
            'port'   => 6379,
        ]);

        $this->client = new Client('tcp://10.0.0.1:6379');
    }

    public function save(EventAddDto $dto): void
    {
        return;
    }

    public function getByParams(array $condition): array
    {
        return [];
    }

    public function deleteAll(): void
    {
        return;
    }
}