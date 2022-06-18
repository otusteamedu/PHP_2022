<?php

namespace Otus\Core\Application;

use Otus\Core\Config\Env;
use Otus\Core\Database\DBConnection;
use Otus\App\Controller\PageController;

class App
{
    private function init(): void
    {
        $this->initEnv();
        $this->initDB();
    }

    public static function make(): self
    {
        return new self();
    }

    public function run(): void
    {
        $this->init();
        (new PageController)();
    }

    private function initEnv(): void
    {
        Env::loadFromEnv(PATH_APP . '.env');
    }

    private function initDB(): void
    {
        $dsn = sprintf(
            '%s:dbname=%s;host=%s',
            Env::get('DB_CONNECTION'),
            Env::get('DB_NAME'),
            Env::get('DB_HOST'),
        );
        $user = Env::get('DB_USER');
        $password = Env::get('DB_PASSWORD');
        DBConnection::setOptions($dsn, $user, $password);
    }
}