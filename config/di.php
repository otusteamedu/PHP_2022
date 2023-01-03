<?php

// Здесь прописываем биндинг для реализаций интерфейсов
use Elastic\Elasticsearch\ClientBuilder;

// todo вынести креды в .env
return [
    \Elastic\Elasticsearch\Client::class => function () {
        return ClientBuilder::create()
//            ->setHosts(['https://elasticsearch:9200'])
            ->setHosts(['https://localhost:9200'])
            ->setBasicAuthentication('elastic', 'Gnu5PqDLyim0p0GcqfJk')
            ->setSSLVerification(false)
            ->build();
    }
];