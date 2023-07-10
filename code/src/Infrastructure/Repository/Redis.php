<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw20\Infrastructure\Repository;

use Nikcrazy37\Hw20\Domain\Request;
use Nikcrazy37\Hw20\libs\Exception\NotFoundElementException;
use Predis\Client;

class Redis
{
    /**
     * @var Client
     */
    private Client $client;

    public function __construct()
    {
        $this->client = new Client(array(
            "host" => $_ENV["REDIS_HOST"]
        ));
    }

    public function add(Request $request): void
    {
        $this->client->set($request->getId(), $request->getStatus()->name);
    }

    public function get(string $iud): string
    {
        $this->existsElement($iud);

        return $this->client->get($iud);
    }

    public function edit(Request $request): void
    {
        $this->existsElement($request->getId());

        $this->add($request);
    }

    public function delete(string $uid): int
    {
        $this->existsElement($uid);

        return $this->client->del($uid);
    }

    private function existsElement(string $key): void
    {
        if (!$this->client->exists($key)) {
            throw new NotFoundElementException($key);
        }
    }
}