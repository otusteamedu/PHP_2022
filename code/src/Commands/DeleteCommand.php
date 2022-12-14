<?php

namespace Ppro\Hw12\Commands;

use Ppro\Hw12\Helpers\AppContext;
use Ppro\Hw12\Elasticsearch\Client;
use Ppro\Hw12\Helpers\Helper;

class DeleteCommand extends Command
{
    /** Запуск приложения в режиме работы с индексом
     * @param AppContext $context
     * @return void
     * @throws \Exception
     */
    public function execute(AppContext $context): void
    {
        if(empty($_SERVER['argv'][2]))
            throw new \Exception("Index name not defined");
        $indexName = $_SERVER['argv'][2];
        $client = new Client($context);
        $client->deleteIndex($indexName);
    }
}