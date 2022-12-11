<?php

declare(strict_types=1);

use Elastic\Elasticsearch\ClientBuilder;
use Eliasjump\Elasticsearch\InputClient;

require __DIR__ . '/../vendor/autoload.php';

new InputClient();


//$client = ClientBuilder::create()
//    ->setHosts(['elasticsearch:9200'])
//    ->build();

// Info API
//$response = $client->info();

//echo $response['version']['number'];