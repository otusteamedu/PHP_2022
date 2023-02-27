<?php

declare(strict_types=1);

namespace App\Provider\Elastic\Query;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class GetVersionQuery implements QueryInterface
{
    private array $version;

    public function __construct(private Client $client)
    {
    }

    /**
     * @return array
     */
    public function getVersion(): array
    {
        return $this->version;
    }

    /**
     * @param array $version
     */
    private function setVersion(array $version): void
    {
        $this->version = $version;
    }

    public function execute(): void
    {
        $this->setVersion($this->requestVersion());
    }

    public function requestVersion(): array
    {
        try {
            $response = $this->client->info();
        } catch (ClientResponseException $e) {
            printf("ClientResponseException %s: %s\n", $e->getCode(), $e->getMessage());
        } catch (ServerResponseException $e) {
            printf("ServerResponseException %s: %s\n", $e->getCode(), $e->getMessage());
        }
        return $response['version'];
    }
}