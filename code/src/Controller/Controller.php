<?php

declare(strict_types=1);

namespace Svatel\Code\Controller;

use Svatel\Code\Client\RedisClient;
use Svatel\Code\Http\Request\Request;

final class Controller
{
    private RedisClient $client;

    public function __construct(RedisClient $client)
    {
        $this->client = $client;
    }

    public function add(Request $request)
    {
        return  $this->client->add($request->getData());
    }

    public function delete(): bool
    {
        return $this->client->delete();
    }

    public function all(): array
    {
        try {
            return $this->client->getAll();
        } catch (\Exception $e) {
            return [];
        }
    }

    public function getByPriority(Request $request): array
    {
        $events = $this->client->getOne();
        $res = [];

        foreach ($events as $key => $value) {
            foreach ($request->getData()[0] as $key1 => $value1) {
                if (strpos($key, $value1)) {
                    $res[] = [$key => $value];
                }
            }
        }

        return $res;
    }
}
