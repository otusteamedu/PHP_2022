<?php

declare(strict_types=1);

namespace Nemizar\OtusShop;

use Elastic\Elasticsearch\ClientBuilder;
use Nemizar\OtusShop\config\ConfigLoader;
use Nemizar\OtusShop\render\ConsoleOutput;

class App
{
    public function run(): void
    {
        $inputParams = (new InputParamsHandler())();

        $config = (new ConfigLoader())();

        $client = ClientBuilder::create()
            ->setHosts([$config->host])
            ->build();

        $output = new ConsoleOutput();
        
        $bookSearch = new BookSearch($config, $client, $output);
        $bookSearch->search($inputParams);
    }
}
