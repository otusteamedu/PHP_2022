<?php

declare(strict_types=1);

namespace Nikolai\Php\ElasticSearchClient;

use Elasticsearch\ClientBuilder;
use Nikolai\Php\Service\ElasticSearchParametersVerifier;
use Symfony\Component\HttpFoundation\Request;

class ElasticSearchClientBuilder implements ElasticSearchClientBuilderInterface
{
    const ELASTICSEARCH_PORT = 'ELASTICSEARCH_PORT';
    const ELASTICSEARCH_HOST = 'ELASTICSEARCH_HOST';

    public static function create(Request $request): ElasticSearchClientInterface
    {
        (new ElasticSearchParametersVerifier())->verify($request);
        $host = $request->server->get(self::ELASTICSEARCH_HOST);
        $port = $request->server->get(self::ELASTICSEARCH_PORT);

        $client = ClientBuilder::create()
            ->setHosts(["${host}:${port}"])
            ->build();

        return new ElasticSearchClient($client);
    }
}