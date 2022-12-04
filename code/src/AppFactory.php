<?php

namespace Waisee\SocketChat;

class AppFactory
{
    /**
     * @throws \Exception
     */
    static function create(string $type)
    {
        if (!isset($type)) {
            throw new \Exception('Необходимо указать тип приложения');
        }

        return match ($type) {
            'server' => new ServerApp(),
            'client' => new ClientApp(),
            default => throw new \Exception('Нет такого типа приложения'),
        };
    }

}