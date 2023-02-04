<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw11\Repository\Redis;

use Predis\Client;
use Nikcrazy37\Hw11\Config;
use Nikcrazy37\Hw11\Dto\EntityDto;
use Nikcrazy37\Hw11\Repository\Repository;
use Nikcrazy37\Hw11\Exception\Element\CreateElementException;
use Nikcrazy37\Hw11\Exception\Element\NotFoundElementException;
use Nikcrazy37\Hw11\Exception\Element\UpdateElementException;
use Nikcrazy37\Hw11\Exception\Element\DeleteElementException;

class Redis implements Repository
{
    private const SUCCESS_CREATE_RESPONSE = array("OK", 1);
    private const SUCCESS_UPDATE_RESPONSE = array(0, "OK");
    private const SUCCESS_DELETE_RESPONSE = array(1, 1);

    /**
     * @var Client
     */
    private Client $client;
    /**
     * @var string|null
     */
    protected ?string $entityName;
    /**
     * @var string|null
     */
    protected ?string $entityMultiName;

    /**
     * @param EntityDto $entity
     */
    public function __construct(EntityDto $entity)
    {
        $this->client = new Client(array(
            "host" => Config::getOption("REDIS_HOST")
        ));

        $this->entityName = $entity->getName();
        $this->entityMultiName = $entity->getMultyName();
    }

    /**
     * @param array $param
     * @param string $score
     * @return int
     * @throws CreateElementException
     */
    public function create(array $param, string $score): int
    {
        $id = $this->getLastId() + 1;

        $this->client->multi();

        $this->client->hmset("$this->entityName:$id", $param);
        $this->client->zadd("$this->entityMultiName", $score, "$this->entityName:$id");

        $result = $this->client->exec();

        if (!array_intersect(self::SUCCESS_CREATE_RESPONSE, $result)) {
            throw new CreateElementException("$this->entityName:$id");
        }

        return $id;
    }

    /**
     * @param string $id
     * @return array
     * @throws NotFoundElementException
     */
    public function read(string $id): array
    {
        $event["param"] = $this->client->hgetall("$this->entityName:$id");
        $event["score"] = $this->client->zscore($this->entityMultiName, "$this->entityName:$id");

        if (empty($event["param"]) && empty($event["score"])) {
            throw new NotFoundElementException("$this->entityName:$id");
        }

        return $event;
    }

    /**
     * @param array $param
     * @param string $score
     * @param string $id
     * @return string
     * @throws NotFoundElementException
     * @throws UpdateElementException
     */
    public function update(array $param, string $score, string $id): string
    {
        $this->existsElement($id);

        $this->client->multi();

        $this->client->hmset("$this->entityName:$id", $param);
        $this->client->zadd("$this->entityMultiName", $score, "$this->entityName:$id");

        $result = $this->client->exec();

        if (!array_intersect(self::SUCCESS_UPDATE_RESPONSE, $result)) {
            throw new UpdateElementException("$this->entityName:$id");
        }

        return $id;
    }

    /**
     * @param string $id
     * @return string
     * @throws DeleteElementException
     * @throws NotFoundElementException
     */
    public function delete(string $id): string
    {
        $this->existsElement($id);

        $this->client->multi();

        $this->client->del("$this->entityName:$id");
        $this->client->zrem($this->entityMultiName, "$this->entityName:$id");

        $result = $this->client->exec();

        if (!array_intersect(self::SUCCESS_DELETE_RESPONSE, $result)) {
            throw new DeleteElementException("$this->entityName:$id");
        }

        return $id;
    }

    /**
     * @return string
     */
    public function clear(): string
    {
        $keys = $this->client->keys("$this->entityName:*");
        array_walk($keys, function ($event) {
            $this->client->del($event);
        });

        $this->client->del($this->entityMultiName);

        return "all";
    }

    /**
     * @param array $query
     * @return mixed|null
     */
    public function search(array $query): mixed
    {
        $keys = $this->client->keys("$this->entityName:*");
        $keys = array_filter($keys, function ($key) use ($query) {
            $element = $this->client->hgetall($key);

            return empty(array_diff($element, $query));
        });
        $keys = array_values($keys);

        $score = $this->client->zmscore($this->entityMultiName, ...$keys);
        $res = array_combine($score, $keys);
        ksort($res);

        return array_shift($res);
    }

    /**
     * @param string $id
     * @return void
     * @throws NotFoundElementException
     */
    private function existsElement(string $id): void
    {
        if (!$this->client->exists("$this->entityName:$id")) {
            throw new NotFoundElementException("$this->entityName:$id");
        }
    }

    /**
     * @return int
     */
    private function getLastId(): int
    {
        $res = $this->client->keys("$this->entityName:*");
        asort($res);
        $id = array_pop($res) ?: "0";

        return (int)str_replace("$this->entityName:", "", $id);
    }
}