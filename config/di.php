<?php

// Здесь прописываем биндинг для реализаций интерфейсов
use Elastic\Elasticsearch\ClientBuilder;

return [
    \Elastic\Elasticsearch\Client::class => function () {
        return ClientBuilder::create()
            ->setHosts([$_ENV['ELASTIC_HOST'] . ':' . $_ENV['ELASTIC_PORT']])
            ->setBasicAuthentication($_ENV['ELASTIC_LOGIN'], $_ENV['ELASTIC_PASSWORD'])
            ->setSSLVerification(false)
            ->build();
    },
    \Predis\Client::class => function() {
        return new \Predis\Client([
            'scheme' => $_ENV['REDIS_SCHEME'],
            'host'   => $_ENV['REDIS_HOST'],
            'port'   => $_ENV['REDIS_PORT'],
        ]);
    },
    \App\App\Event\EventStorageInterface::class => \App\App\Event\RedisEventStorage::class,
    \PDO::class => function() {
        return new \PDO($_ENV['DB_DSN'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
    },
];