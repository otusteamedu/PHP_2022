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
    }
];