<?php

declare(strict_types=1);

namespace App\Provider\Elastic\Query;

use App\Provider\Elastic\Command\GetVersionCommand;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class GetVersionQuery implements QueryInterface
{
    public function __construct(private GetVersionCommand $command)
    {
    }

    public function execute(): void
    {
        $version = $this->getVersion();
        echo $version['number'] . PHP_EOL;
    }

    public function getVersion(): array
    {
        try {
            $response = $this->command->getClient()->info();
        } catch (ClientResponseException $e) {
            printf("ClientResponseException %s: %s\n", $e->getCode(), $e->getMessage());
        } catch (ServerResponseException $e) {
            printf("ServerResponseException %s: %s\n", $e->getCode(), $e->getMessage());
        }
        return $response['version'];
    }
}