<?php

declare(strict_types=1);

namespace App\SearchEngine\Mechanisms;

use App\SearchEngine\Mechanisms\DTO\QueryParamsDTO;

final class QueryBuilder
{
    private QueryParamsDTO $query_params_dto;
    private array $configuration;

    /**
     * @param QueryParamsDTO $query_params_dto
     */
    public function __construct(QueryParamsDTO $query_params_dto)
    {
        $this->query_params_dto = $query_params_dto;

        $configuration_instance = Configuration::getInstance();
        $this->configuration = $configuration_instance->getConfig();
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function buildQuery(): array
    {
        return [
            'index' => $this->configuration['es_index'],
            'body' => $this->parseQueryData(),
        ];
    }

    /*
    |-------------------------------------------------------------------------------------------------------------------
    | PRIVATE FUNCTIONS
    |-------------------------------------------------------------------------------------------------------------------
    */

    /**
     * @return array
     * @throws \Exception
     */
    private function parseQueryData(): array
    {
        $query = [];

        $cleaning_empty_values = array_filter(
            array: (array) $this->query_params_dto,
            callback: fn ($value) => ! empty($value)
        );

        foreach ($cleaning_empty_values as $param_name => $param_value) {
            try {
                $class = 'App\SearchEngine\Mechanisms\Services\QueryBuilder\\'
                    . ucfirst(string: $param_name) . 'QueryParams';

                if (str_contains(haystack: $param_name, needle: '_')) {
                    $param_name_parts = explode(separator: '_', string: $param_name);

                    $class = 'App\SearchEngine\Mechanisms\Services\QueryBuilder\\' .
                        ucfirst(string: $param_name_parts[0]) . ucfirst(string: $param_name_parts[1]) . 'QueryParams';
                }

                $query['query']['bool']['must'][] =
                    $class::getParam(field_name: $param_name, field_value: $param_value);
            } catch (\Throwable $exception) {
                throw new \Exception(
                    message: 'Method: ' . __METHOD__ . 'Error: Can\'t find class. ' . $exception->getMessage()
                );
            }
        }

        return $query;
    }
}
