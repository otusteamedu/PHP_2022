<?php

declare(strict_types=1);

namespace HW10\App;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use HW10\App\DTO\Book;
use HW10\App\DTO\Store;

class App
{
    private const INDEX_FILE = '../index/books.json';
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
        echo '<pre>'; print_r($this->prepareParams($this->getInputParams())); echo '</pre>';
        $response = $this->client->search($this->prepareParams($this->getInputParams()));
        $result = $response->asArray()['hits']['hits'];
        $this->output->echo($this->formatResponse($result));
    }

    public function makeIndex(): void
    {
        if (file_exists(self::INDEX_FILE)) {
            $books = file_get_contents(self::INDEX_FILE);
            $response = $this->client->bulk(['body' => $books]);

            if (!$response['errors']) {
                print_r('Данные из файла успешно добавлены в индекс!');
            } else {
                print_r('При добавлении данных из файла в индекс возникли ошибки!');
            }
        } else {
            throw new \Exception('Файл индекса отсутствует');
        }
    }

    private function getInputParams(): array
    {
        return \getopt(
            '',
            [
                'title:',
                'sku:',
                'category:',
                'in_stock:',
                'price_from:',
                'price_to:',
                'limit:',
                'offset:',
            ]
        );
    }

    private function formatResponse(array $response): array
    {
        $preparedResult = [];
        foreach ($response as $bookInfo) {
            $book = new Book(
                $bookInfo['_source']['sku'],
                $bookInfo['_source']['title'],
                $bookInfo['_source']['category'],
                $bookInfo['_source']['price']
            );
            foreach ($bookInfo['_source']['stock'] as $stockInfo) {
                $book->addStores(new Store($stockInfo['shop'], $stockInfo['stock']));
            }
            $preparedResult[] = $book;
        }
        return $preparedResult;
    }

    private function prepareParams(array $params): array
    {
        $conditions = [];
        foreach ($params as $name => $value) {
            switch ($name) {
                case 'title':
                    $conditions['match'][$name] = [
                        'query' => $value,
                        'fuzziness' => 'auto',
                    ];
                    break;
                case 'sku':
                case 'category':
                    $conditions['term'][$name] = [
                        'value' => $value,
                    ];
                    break;
                case 'in_stock':
                    $conditions['nested'] = [
                        'path' => 'stock',
                        'query' => [
                            [
                                'range' => [
                                    'stock.stock' => [
                                        'gt' => '0',
                                    ],
                                ],
                            ],
                            [
                                'term' => [
                                    'stock.shop' => [
                                        'value' => $value,
                                    ],
                                ],
                            ],
                        ],
                    ];
                    break;
                case 'price_from':
                    if (!$value) {
                        break;
                    }
                    $conditions['range']['price'] = [
                        'gte' => $value,
                    ];
                    break;
                case 'price_to':
                    if (!$value) {
                        break;
                    }
                    $conditions['range']['price'] = [
                        'lte' => $value,
                    ];
                    break;
                case 'limit':
                    $limit = (int)$value;
                    break;
                case 'offset':
                    $offset = (int)$value;
            }
        }

        if (empty($conditions)) {
            $conditions = [
                'match_all' => (object)[],
            ];
        }

        return [
            'index' => $_ENV['ELASTIC_INDEX'],
            'body' => [
                'size' => $limit ?? 25,
                'from' => $offset ?? 0,
                'query' => $conditions,
            ],
        ];
    }
}
