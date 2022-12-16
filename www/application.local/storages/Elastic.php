<?php

namespace app\storages;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;

trait Elastic {
    public Client $client;

    public function setStorageClient(): void {
        $this->client = ClientBuilder::create()
            ->setHosts([$_ENV['ELASTIC_HOST']])
            ->setBasicAuthentication($_ENV['ELASTIC_USERNAME'], $_ENV['ELASTIC_PASSWORD'])
            ->build();
    }
}
