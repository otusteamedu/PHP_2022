<?php

namespace HW10\App\ElasticSearch;

use DI;
use DI\ContainerBuilder;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Client;
use HW10\App\Interfaces\OutputInterface;
use HW10\App\Outputs\Output;
use Exception;

class ElasticSearchApp
{
    private $output;
    private const INDEX_FILE = __DIR__ . '/../index/books.json';

    public function __construct()
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions(
            [
                OutputInterface::class =>
                    DI\create(Output::class),
            ]
        );
        $container = $builder->build();
        $this->output = $container->get(Output::class);
    }

    public function getClient(): Client
    {
        return ClientBuilder::create()
            ->setHosts([$_ENV['ELASTIC_HOST']])
            ->build();
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
            throw new Exception('Файл индекса отсутствует');
        }
    }
}
