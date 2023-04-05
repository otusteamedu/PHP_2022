<?php

declare(strict_types=1);

namespace Svatel\Code\Controller;

use Svatel\Code\Client\RedisClient;
use Svatel\Code\Http\Request\Request;
use Svatel\Code\Http\Response\Response;

final class Controller
{
    private RedisClient $client;

    public function __construct(RedisClient $client)
    {
        $this->client = $client;
    }

    public function add(Request $request)
    {
        $eventKey = 'conditions:';
        $conditions = $request->getData()['conditions'];
        $count = 0;
        foreach ($conditions as $key => $value) {
            $eventKey .= $key . '=' . $value;
            if ($count != count($conditions) - 1) {
                $eventKey .= ',';
            }
            $count++;
        }

        $res = $this->client->add([$eventKey => $request->getData()['priority']]);

        return $res
            ? new Response(201, 'Добавление прошло успешно')
            : new Response(500, 'Ошибка при добавлени');
    }

    public function delete(): Response
    {
        $res = $this->client->delete();
        return $res
            ? new Response(201, 'Удаление прошло успешно')
            : new Response(500, 'Ошибка при удалении');
    }

    public function all(): Response
    {
        try {
            $res = $this->client->getAll();
            return new Response(201, '', $res);
        } catch (\Exception $e) {
            return new Response(500, 'Произошла ошибка');
        }
    }

    public function getByBody(Request $request): Response
    {
        try {
            $events = $this->client->getOne();

            $res = [];

            $search = '';
            $params = $request->getData()['params'];
            $count = 0;
            foreach ($params as $key => $value) {
                $search .= $value;
                if ($count != count($params) - 1) {
                    $search .= ',';
                }
                $count++;
            }

            foreach ($events as $key => $value) {
                if (strpos($key, $search)) {
                    $res[] = [$key => $value];
                }
            }

            return new Response(201, '', $res);
        } catch (\Exception $e) {
            return new Response(500, 'Произошла ошибка');
        }
    }
}
