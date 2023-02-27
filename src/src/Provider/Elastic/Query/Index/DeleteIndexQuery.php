<?php

declare(strict_types=1);

namespace App\Provider\Elastic\Query\Index;

use App\Provider\Elastic\Command\Index\DeleteIndexCommand;
use App\Provider\Elastic\Query\QueryInterface;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Http\Promise\Promise;

class DeleteIndexQuery implements QueryInterface
{
    public function __construct(private DeleteIndexCommand $command, private Client $client)
    {
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function execute(): void
    {
        $response = $this->deleteIndexRequest();

        if ($response instanceof Promise) {
            echo 'Command in process... Status ' . $response->getState() . PHP_EOL;
        } else {
            $code = $response->getStatusCode();
            $message = match ($code) {
                200 => 'Success. Index was deleted',
                default => 'Failure ' . $code . ' ' . $response->getReasonPhrase()
            };
            echo $message . PHP_EOL;
        }
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     */
    public function deleteIndexRequest(): Elasticsearch|Promise
    {
        return $this->client->indices()->delete($this->command->buildParams());
    }
}
