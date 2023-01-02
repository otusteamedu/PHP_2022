<?php

declare(strict_types=1);

namespace HW10\App;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use HW10\App\Interfaces\OutputInterface;

class App
{
    private const INDEX_FILE = __DIR__ . '/../index/books.json';

    private Client $client;

    private OutputInterface $output;

    public function __construct($output)
    {
        $this->client = ClientBuilder::create()
            ->setHosts([$_ENV['ELASTIC_HOST']])
            ->build();
        $this->output = new $output();
    }

    public function run($query, $bookDTO): void
    {
        $queryParams = (new $query())->getPreparedParams();
        $response = $this->client->search($queryParams);

        $result = $response->asArray()['hits']['hits'];
        $this->output->echo($query::prepareResponse($result, $bookDTO));
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
