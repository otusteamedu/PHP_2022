<?php

declare(strict_types=1);

namespace HW10\App;

use DI;
use DI\ContainerBuilder;
use Elastic\Elasticsearch\Client;
use HW10\App\DTO\BookProductDTO;
use HW10\App\ElasticSearch\ElasticSearchApp;
use HW10\App\Interfaces\OutputInterface;
use HW10\App\Interfaces\QueryInterface;
use HW10\App\Outputs\ProductsOutput;
use HW10\App\Queries\SearchProductQuery;

class App
{
    private Client $client;
    private OutputInterface $output;
    private QueryInterface $query;

    public function __construct()
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions(
            [
                OutputInterface::class =>
                    DI\create(ProductsOutput::class),
                QueryInterface::class =>
                    DI\create(SearchProductQuery::class),
                ElasticSearchApp::class =>
                    DI\create(ElasticSearchApp::class)
            ]
        );
        $container = $builder->build();

        $this->output = $container->get(ProductsOutput::class);
        $this->query = $container->get(SearchProductQuery::class);
        $this->client = $container->get(ElasticSearchApp::class)->getClient();
    }

    public function run(): void
    {
        $queryParams = $this->query->getPreparedParams();
        $response = $this->client->search($queryParams);
        $result = $response->asArray()['hits']['hits'];

        $this->output->echo($this->query::prepareResponse($result, BookProductDTO::class));
    }
}
