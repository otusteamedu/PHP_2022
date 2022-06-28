<?php

declare(strict_types=1);

namespace App\Service;

use App\Service\Logger\LoggerInterface;
use Console_Table;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Http\Promise\Promise;

class BookFinder
{
    static public int $limit = 25;

    public function __construct(
        private readonly string $indexName,
        private readonly Client $esClient,
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function search(array $input): Elasticsearch|Promise
    {
        $conditions = [];
        $limit = self::$limit;
        $offset = 0;

        array_walk($input, static function ($particle_value, $particle_name) use (&$conditions, &$limit, &$offset) {

            switch ($particle_name) {

                case 'limit':
                    $limit = (int)$particle_value;
                    break;

                case 'offset':
                    $offset = (int)$particle_value;
                    break;

                case 'title':
                    $conditions['bool']['must'][]['match'][$particle_name] = [
                        'query' => $particle_value,
                        'fuzziness' => "auto",
                    ];
                    break;

                case 'sku':
                case 'category':
                    $conditions['bool']['must'][]['term'][$particle_name] = [
                        'value' => $particle_value,
                    ];
                    break;

                case 'in_stock':
                    $conditions['bool']['must'][]['nested'] = [
                        'path' => 'stock',
                        'query' => [
                            'bool' => [
                                'filter' => [
                                    0 => [
                                        'range' => [
                                            'stock.stock' => [
                                                'gt' => '0',
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ];
                    break;

                case 'price_from':
                    $conditions['bool']['filter'][] = [
                        'range' => [
                            'price' => [
                                'gte' => $particle_value ?? null,
                            ],
                        ],
                    ];
                    break;

                case 'price_to':
                    $conditions['bool']['filter'][] = [
                        'range' => [
                            'price' => [
                                'lte' => $particle_value ?? null,
                            ],
                        ],
                    ];
                    break;
            }
        });

        if (empty($conditions)) {
            $conditions = [
                'match_all' => (object)[],
            ];
        }

        $params = [
            'index' => $this->indexName,
            'body' => [
                'size' => $limit,
                'from' => $offset,
                'query' => $conditions,
            ],
        ];

        return $this->esClient->search($params);
    }

    public function renderResultTable(Elasticsearch $response): void
    {
        $tbl = new Console_Table();
        $tbl->setHeaders(['Total docs', 'Max score', 'Took']);
        $tbl->addRow([
            $response['hits']['total']['value'],
            $response['hits']['max_score'],
            $response['took'],
        ]);

        $this->logger->log($tbl->getTable());

        $tbl_books = new Console_Table();
        $tbl_books->setHeaders(['ID', 'Score', 'Source', 'Category', 'Price', 'Stock']);

        foreach ($response['hits']['hits'] as $result) {

            $tbl_stock = new Console_Table();
            foreach ($result['_source']['stock'] as $stock) {
                $tbl_stock->addRow([$stock['shop'], $stock['stock']]);
            }

            $tbl_books->addRow([
                $result['_id'],
                $result['_score'],
                $result['_source']['title'],
                $result['_source']['category'],
                $result['_source']['price'],
                $tbl_stock->getTable(),
            ]);
        }

        $this->logger->log($tbl_books->getTable());
    }
}