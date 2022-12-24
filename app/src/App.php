<?php

declare(strict_types=1);

namespace HW10\App;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use HW10\App\DTO\Book;
use HW10\App\QueryParams;

class App
{
    private const INDEX_FILE = __DIR__ . '/../index/books.json';
    private Client $client;
    private Output $output;

    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts([$_ENV['ELASTIC_HOST']])
            ->build();
        $this->output = new Output();
    }

    public function run(): void
    {
        $queryParams = (new QueryParams())->getPreparedParams();
        $response = $this->client->search($queryParams);

        $result = $response->asArray()['hits']['hits'];
        $this->output->echo(QueryParams::prepareResponse($result, Book::class));
    }

    public function makeIndex(): void
    {
        if (file_exists(self::INDEX_FILE)) {
            $books = file_get_contents(self::INDEX_FILE);
            $response = $this->client->bulk(['body' => $books]);

            if (!$response['errors']) {
                $this->output->echoMessage('Данные из файла успешно добавлены в индекс!');
            } else {
                $this->output->echoMessage('При добавлении данных из файла в индекс возникли ошибки!');
            }
        } else {
            throw new \Exception('Файл индекса отсутствует');
        }
    }
}
