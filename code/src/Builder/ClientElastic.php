<?php

namespace Svatel\Code\Builder;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;

class ClientElastic
{
    public static function build(): Client
    {
        return ClientBuilder::create()
            ->setHosts([getenv('ELASTIC_HOST')])
            ->setBasicAuthentication('elastic', getenv('ELASTIC_PASS'))
            ->setCABundle(getenv('ELASTIC_CERT_PATH'))
            ->build();
    }
}