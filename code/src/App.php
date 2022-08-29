<?php

namespace Rs\Rs;

use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Rs\Rs\Dto\initFilterDto;

class App
{

    /**
     * @return void
     * @throws AuthenticationException
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function run():void
    {
        $dtoParams=new initFilterDto();
        $elastic_object=(new ElasticFindBook())->buildQuery($dtoParams)->search();
        PrintResult::print($elastic_object);
    }
}