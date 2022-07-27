<?php

namespace Command;

use Dto\ElasticConfigDto;
use Dto\InputParametersDto;
use Elastic\Elasticsearch\Client;

class FindBookCommand
{
    public function __construct(
        private PrintResultCommand $printResultCommand
    ) { }

    public function execute(InputParametersDto $parametersDto, Client $client, ElasticConfigDto $config): void
    {
        $queries = $this->buildQuery($parametersDto);

        $search = $client->search(
            [
                'index' => $config->index,
                'body' => [
                    'size' => $parametersDto->getLimit(),
                    'from' => $parametersDto->getOffset(),
                    'query' => $queries
                ],
            ]
        );

        $this->printResultCommand->execute($search);
    }

    /**
     * @param InputParametersDto $inputParametersDto
     * @return array
     */
    private function buildQuery(InputParametersDto $inputParametersDto): array
    {
        $queries = [];

        if ($inputParametersDto->getTitle() !== '') {
            $queries['bool']['must'][]['match']['title'] = [
                'query' => $inputParametersDto->getTitle(),
                'fuzziness' => "auto",
            ];
        }

        if ($inputParametersDto->getSku() !== '') {
            $queries['bool']['must'][]['term']['sku'] = [
                'value' => $inputParametersDto->getSku(),
            ];
        }

        if ($inputParametersDto->getCategory() !== '') {
            $queries['bool']['must'][]['term']['category'] = [
                'value' => $inputParametersDto->getCategory(),
            ];
        }

        if ($inputParametersDto->getPriceLow() !== 0) {
            $queries['bool']['filter'][] = [
                'range' => [
                    'price' => [
                        'gte' => $inputParametersDto->getPriceLow()
                    ]
                ]
            ];
        }

        if ($inputParametersDto->getPriceHigh() !== 0) {
            $queries['bool']['filter'][] = [
                'range' => [
                    'price' => [
                        'lte' => $inputParametersDto->getPriceLow()
                    ]
                ]
            ];
        }

        return $queries;
    }
}
