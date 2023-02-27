<?php

declare(strict_types=1);

namespace App\Provider\Elastic\Query\Index;

use App\Provider\Elastic\Command\Index\GetIndexCommand;
use App\Provider\Elastic\Query\QueryInterface;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Http\Promise\Promise;
use JsonException;

class GetIndexQuery implements QueryInterface
{
    private array $result = [];

    public function __construct(private GetIndexCommand $command, private Client $client)
    {
    }

    /**
     * @return array
     */
    public function getResult(): array
    {
        return $this->result;
    }

    /**
     * @param array $result
     */
    private function setResult(array $result): void
    {
        $this->result = $result;
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException|JsonException
     */
    public function execute(): void
    {
        $response = $this->getIndexRequest();

        if ($response instanceof Promise) {
            echo 'Command in process... Status ' . $response->getState() . PHP_EOL;
        } else if (($code = $response->getStatusCode()) === 200) {
            $this->setResult(
                json_decode(
                    (string)$response->getBody(),
                    true,
                    512,
                    JSON_THROW_ON_ERROR
                )
            );
        } else {
            'Failure ' . $code . ' ' . $response->getReasonPhrase() . PHP_EOL;
        }
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     */
    public function getIndexRequest(): Elasticsearch|Promise
    {
        return $this->client->indices()->get($this->command->buildParams());
    }
}