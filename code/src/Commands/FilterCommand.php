<?php

namespace Ppro\Hw12\Commands;

use Ppro\Hw12\Elasticsearch\Request;
use Ppro\Hw12\Helpers\AppContext;
use Ppro\Hw12\Elasticsearch\Client;

class FilterCommand extends Command
{
    /** Запуск приложения в режиме работы с индексом
     * @param AppContext $context
     * @return void
     * @throws \Exception
     */
    public function execute(AppContext $context): void
    {
        if(empty($_SERVER['argv'][2]))
            throw new \Exception("Index not defined");
        $params['index'] = $_SERVER['argv'][2];
        $params['body'] = Request::getBodyForFilter($_SERVER['argv']);
        $client = new Client($context);
        $client->filterIndex($params);
    }
}