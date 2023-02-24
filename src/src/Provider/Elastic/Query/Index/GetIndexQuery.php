<?php

declare(strict_types=1);

namespace App\Provider\Elastic\Query\Index;

use App\Provider\Elastic\Command\Index\GetIndexCommand;
use App\Provider\Elastic\Query\QueryInterface;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Http\Promise\Promise;

class GetIndexQuery implements QueryInterface
{
    public function __construct(private GetIndexCommand $command)
    {
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function execute(): void
    {
        $response = $this->getIndexRequest();

        if ($response instanceof Promise) {
            echo 'Command in process... Status ' . $response->getState() . PHP_EOL;
        } else {
            $code = $response->getStatusCode();
            $message = match ($code) {
                200 => $response->getBody(),
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
    public function getIndexRequest(): Elasticsearch|Promise
    {
        return $this->command->getClient()->indices()->get($this->command->buildParams());
    }
}