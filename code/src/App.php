<?php

declare(strict_types=1);

namespace Otus\App;

use Otus\App\Config\InputParamsHandler;
use Otus\App\Core\ElasticClient;
use Otus\App\Viewer\ConsoleOutput;

class App
{
    protected array $options = [];
    private array $inputParams;
    private ElasticClient $client;
    private ConsoleOutput $output;

    public function __construct()
    {
        $this->inputParams = (new InputParamsHandler())();
        $this->client = new ElasticClient();
        $this->output = new ConsoleOutput();
    }

    public function run(): void
    {
        $result = $this->client->search($this->inputParams);
        $this->output->echo($result);
    }
}
