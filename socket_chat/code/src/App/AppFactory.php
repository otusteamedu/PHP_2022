<?php

declare(strict_types=1);

namespace Mapaxa\SocketChatApp\App;


use Mapaxa\SocketChatApp\Config\AppConfig;

class AppFactory
{
    public static function createApp(): AppInterface
    {
        if (isset($_ENV['APP_TYPE'])) {
            $appType = ucfirst(trim($_ENV['APP_TYPE']));
        } else {
            throw new \Exception('Необходимо указать тип приложения в $_ENV[\'APP_TYPE\']');
        }

        $appClassname = AppConfig::APP_DIR_PATH . $appType;

        if (class_exists($appClassname)) {
            return new $appClassname();
        } else {
            throw new \Exception('Класс ' . $appClassname . 'не существует.');
        }
    }
}