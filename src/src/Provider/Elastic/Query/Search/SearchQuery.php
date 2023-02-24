<?php

declare(strict_types=1);

namespace App\Provider\Elastic\Query\Search;

use App\Provider\Elastic\Command\Search\SearchCommand;
use App\Provider\Elastic\Helper\PrintHelper;
use App\Provider\Elastic\Query\QueryInterface;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Http\Promise\Promise;

class SearchQuery implements QueryInterface
{
    public function __construct(private SearchCommand $command)
    {
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function execute(): void
    {
        $response = $this->createSearchRequest();

        if ($response instanceof Promise) {
            echo 'Search in process... Status ' . $response->getState() . PHP_EOL;
        } else {
            $code = $response->getStatusCode();
            if ($code === 200) {
                printf("Total docs: %d\n", $response['hits']['total']['value']);
                printf("Max score : %.4f\n", $response['hits']['max_score']);
                printf("Took      : %d ms\n", $response['took']);

                //    print_r($response['hits']['hits']); // documents
                echo PrintHelper::getCyrillicFormattedStr("| %s || %-25s || %-50s |\n", 'Артикул', 'Категория', 'Название');
                foreach ($response['hits']['hits'] as $hit) {
                    echo PrintHelper::getCyrillicFormattedStr("| %s || %-25s || %-50s |\n", $hit['_source']['sku'], $hit['_source']['category'], $hit['_source']['title']);
                }
            } else {
                echo 'Failure ' . $code . ' ' . $response->getReasonPhrase() . PHP_EOL;
            }
        }

    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function createSearchRequest(): Elasticsearch|Promise
    {
        return $this->command->getClient()->search($this->command->buildParams());
    }

}
