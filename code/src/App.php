<?php

declare(strict_types=1);

namespace Otus\App;

use Otus\App\Config\InputParamsHandler;
use Otus\App\Core\DataRepositoryClient;
use Otus\App\Core\BookRepositoryClient;
use Otus\App\Viewer\ConsoleOutput;

/**
 * App class
 */
class App
{
    protected array $options = [];
    private array $inputParams;
    private DataRepositoryClient $client;
    private ConsoleOutput $output;

    /**
     * App Constructor
     */
    public function __construct()
    {
        $this->inputParams = (new InputParamsHandler())();
        $this->client = new BookRepositoryClient();
        $this->output = new ConsoleOutput();
    }

    /**
     * App runner
     * @return void
     * @throws \Elastic\Elasticsearch\Exception\ClientResponseException
     * @throws \Elastic\Elasticsearch\Exception\ServerResponseException
     */
    public function run(): void
    {
        $result = $this->client->search($this->inputParams);
        $this->output->echo($result);
    }
}
