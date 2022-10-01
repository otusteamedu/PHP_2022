<?php

declare(strict_types=1);

namespace Nikolai\Php\Controller;

use Nikolai\Php\ElasticSearchClient\ElasticSearchClient;
use Nikolai\Php\Service\FileReader;
use Symfony\Component\HttpFoundation\Request;

class InsertController
{
    const ELASTICSEARCH_FILE = 'ELASTICSEARCH_FILE';

    public function __construct(private ElasticSearchClient $elasticSearchClient) {}

    public function __invoke(Request $request)
    {
        $file = dirname(__DIR__, 2) . $request->server->get(self::ELASTICSEARCH_FILE);
        $books = (new FileReader($file))->read();

        $response = $this->elasticSearchClient->bulk(['body' => $books]);
        if (!$response['errors']) {
            echo 'Данные из файла успешно добавлены в индекс!' . PHP_EOL;
        }
        else {
            echo 'При добавлении данных из файла в индекс возникли ошибки!' . PHP_EOL;
        }
    }
}