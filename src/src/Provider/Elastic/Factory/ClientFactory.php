<?php

declare(strict_types=1);

namespace App\Provider\Elastic\Factory;

use App\Provider\Elastic\DTO\ConnectionParamsDTO;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;

class ClientFactory
{
    public static function create(ConnectionParamsDTO $params): Client
    {
        try {
            $client = ClientBuilder::create()
                ->setHosts([$params->getHost()])
                ->setBasicAuthentication($params->getUser(), $params->getPassword())
                ->setCABundle($params->getCertPath())
                ->build();
        } catch (AuthenticationException $e) {
            printf("AuthenticationException: %s\n", $e->getMessage());
        }
        return $client;
    }
}
