<?php
namespace Study\Cinema\Infrastructure\Controller\Api\v1;

class DocumentationController
{
    public function index()
    {
        header( 'Content-Type: application/json' );
        $openapi = \OpenApi\Generator::scan( [__DIR__] );
        echo $openapi->toJson();
    }

}