<?php

declare(strict_types=1);

namespace App\SearchEngine\Mechanisms;

use App\SearchEngine\Mechanisms\DTO\QueryParamsDTO;

final class QueryBuilder
{
    private const NAMESPACE_TO_CONCRETE_QUERY_BUILDER_CLASS = 'App\SearchEngine\Mechanisms\Services\QueryBuilder\\';
    private const SECOND_PART_NAME_CONCRETE_QUERY_BUILDER_CLASS = 'QueryParams';

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
                $class = self::NAMESPACE_TO_CONCRETE_QUERY_BUILDER_CLASS
                    . ucfirst(string: $param_name) . self::SECOND_PART_NAME_CONCRETE_QUERY_BUILDER_CLASS;

                if (str_contains(haystack: $param_name, needle: '_')) {
                    $param_name_parts = explode(separator: '_', string: $param_name);

                    $tmp_class_name = array_reduce(
                        array: $param_name_parts,
                        callback: function ($tmp, $value) {
                            $tmp .= ucfirst($value);

                            return ucfirst($tmp);
                        },
                        initial: ''
                    );

                    $class = self::NAMESPACE_TO_CONCRETE_QUERY_BUILDER_CLASS . $tmp_class_name
                        . self::SECOND_PART_NAME_CONCRETE_QUERY_BUILDER_CLASS;
                }

                $query = array_merge($query, $class::getParam(field_name: $param_name, field_value: $param_value));
            } catch (\Throwable $exception) {
                throw new \Exception(
                    message: 'Method: ' . __METHOD__ . 'Error: Can\'t find class. ' . $exception->getMessage()
                );
            }
        }

        return $query;
    }
}
