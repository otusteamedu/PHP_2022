<?php

declare(strict_types=1);

namespace App\SearchEngine\Mechanisms;

use Elastic\Elasticsearch\{Client, ClientBuilder, Exception\AuthenticationException};

final class Connection
{
    private array $configuration;

    /**
     * class construct
     */
    public function __construct()
    {
        $configuration_instance = Configuration::getInstance();
        $this->configuration = $configuration_instance->getConfig();
    }

    /**
     * @return Client
     * @throws AuthenticationException
     */
    public function connect(): Client
    {
        return ClientBuilder::create()
            ->setHosts(hosts: [$this->configuration['es_host']])
            ->setBasicAuthentication(
                username: $this->configuration['es_username'],
                password: $this->configuration['ELASTIC_PASSWORD']
            )
            ->setCABundle(cert: __DIR__ . '/../../../es01.crt')
            ->build();
    }
}
