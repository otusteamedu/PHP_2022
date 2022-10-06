<?php

declare(strict_types=1);

namespace Nikolai\Php\Controller;

use Nikolai\Php\Service\FileReader;
use Symfony\Component\HttpFoundation\Request;

class InsertController extends AbstructController
{
    const ELASTICSEARCH_FILE = 'ELASTICSEARCH_FILE';

    public function __invoke(Request $request)
    {
        $file = dirname(__DIR__, 2) . $request->server->get(self::ELASTICSEARCH_FILE);
        $books = (new FileReader($file))->read();

        $response = $this->elasticSearchClient->bulk(['body' => $books]);
        if (!$response['errors']) {
            $this->dumper->dump('Данные из файла успешно добавлены в индекс!');
        }
        else {
            $this->dumper->dump('При добавлении данных из файла в индекс возникли ошибки!');
        }
    }
}