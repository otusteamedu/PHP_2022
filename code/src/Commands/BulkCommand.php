<?php

namespace Ppro\Hw12\Commands;

use Ppro\Hw12\Elasticsearch\Request;
use Ppro\Hw12\Helpers\AppContext;
use Ppro\Hw12\Elasticsearch\Client;

class BulkCommand extends Command
{
    /** Запуск приложения в режиме работы с индексом
     * @param AppContext $context
     * @return void
     * @throws \Exception
     */
    public function execute(AppContext $context): void
    {
        if(!isset($_SERVER['argv'][2]))
            throw new \Exception("Not defined JSON filepath\r\n");
        if(empty($_SERVER['argv'][2]) || !file_exists($_SERVER['argv'][2]))
            throw new \Exception("JSON file not found\r\n");
        $params['body'] = Request::getBodyForBulk($_SERVER['argv'][2]);
        $client = new Client($context);
        $client->bulk($params);
    }
}