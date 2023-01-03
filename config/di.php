<?php

// Здесь прописываем биндинг для реализаций интерфейсов
use Elastic\Elasticsearch\ClientBuilder;

// todo вынести креды в .env
return [
    \Elastic\Elasticsearch\ClientInterface::class => function () {
        return ClientBuilder::create()
            ->setHosts(['localhost:9200'])
            ->setBasicAuthentication('elastic', '2tlgm369S5_rZHIQnqkU')
            ->setCABundle(__DIR__ . '/../cert/elastic_http_ca.crt')
            ->build();
    }
];