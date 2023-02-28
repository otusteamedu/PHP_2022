<?php

declare(strict_types=1);

namespace Nemizar\OtusShop;

use Nemizar\OtusShop\clients\ElasticClient;
use Nemizar\OtusShop\components\config\ConfigLoader;
use Nemizar\OtusShop\components\InputParamsHandler;
use Nemizar\OtusShop\render\ConsoleOutput;

class App
{
    private array $inputParams;

    private ElasticClient $client;

    private ConsoleOutput $output;

    public function __construct()
    {
        $this->inputParams = (new InputParamsHandler())();
        $config = (new ConfigLoader())();
        $this->client = new ElasticClient($config);
        $this->output = new ConsoleOutput();
    }

    public function run(): void
    {
        $result = $this->client->search($this->inputParams);
        $this->output->echo($result);
    }
}
