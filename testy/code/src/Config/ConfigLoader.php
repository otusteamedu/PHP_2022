<?php
declare(strict_types=1);

namespace Mapaxa\ElasticSearch\Config;


use Dotenv\Dotenv;

class ConfigLoader
{
    public function __invoke(): Config
    {
        $dotenv = Dotenv::createImmutable(dirname(dirname(__DIR__)) . '/config', 'config');
        $dotenv->load();

        return new Config($_ENV['HOST']);
    }
}