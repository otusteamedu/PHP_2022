<?php

// Здесь прописываем биндинг для реализаций интерфейсов
use App\Application\Queue\BusInterface;
use App\Infrastructure\Queue\Rabbit\RabbitBus;
use Elastic\Elasticsearch\ClientBuilder;
use PhpAmqpLib\Connection\AMQPStreamConnection;

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
    \PDO::class => function() {
        return new \PDO($_ENV['DB_DSN'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
    },
    BusInterface::class => RabbitBus::class,
    AMQPStreamConnection::class => function () {
        return new AMQPStreamConnection(
            $_ENV['RABBITMQ_HOST'],
            $_ENV['RABBITMQ_PORT'],
            $_ENV['RABBITMQ_DEFAULT_USER'],
            $_ENV['RABBITMQ_DEFAULT_PASS']
        );
    },
];