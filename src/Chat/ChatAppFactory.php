<?php

declare(strict_types=1);

namespace Nemizar\Php2022\Chat;

use InvalidArgumentException;
use Nemizar\Php2022\Chat\Config\ConfigLoader;
use Nemizar\Php2022\Client;
use Nemizar\Php2022\Server;

class ChatAppFactory
{
    public static function getApp(): ChatApp
    {
        if (!isset($_SERVER['argv'][1])) {
            throw new InvalidArgumentException('Необходимо указать какое приложение необходимо запустить: server или client');
        }

        $appType = $_SERVER['argv'][1];

        $config = (new ConfigLoader())();

        if ($appType === 'server') {
            return new Server($config);
        }

        if ($appType === 'client') {
            return new Client($config);
        }

        throw new InvalidArgumentException('Передан неверный параметр. Допустимые значения: server или client');
    }
}
