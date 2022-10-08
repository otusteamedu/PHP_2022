<?php

declare(strict_types=1);

namespace App\SearchEngine\Validation;

use App\SearchEngine\Mechanisms\DTO\QueryParamsDTO;

final class Validator
{
    private const NAMESPACE_TO_CONCRETE_VALIDATOR = '\App\SearchEngine\Validation\Services\\';
    private const SECOND_PART_NAME_CONCRETE_VALIDATOR_CLASS = 'Validation';

    private QueryParamsDTO $query_params_dto;

    /**
     * @param QueryParamsDTO $query_params_dto
     */
    public function __construct(QueryParamsDTO $query_params_dto)
    {
        $this->query_params_dto = $query_params_dto;
    }

    /**
     * @return bool
     */
    public function validate(): bool
    {
        foreach ($this->query_params_dto as $query_param_name => $query_param_value) {
            // так приходится делать, потому что ! empty() строку с нулем воспринимает как пустую
            if ((string) $query_param_value !== '') {
                $param_name = ucfirst(string: $query_param_name);

                $concrete_validator = self::NAMESPACE_TO_CONCRETE_VALIDATOR
                    . $param_name . self::SECOND_PART_NAME_CONCRETE_VALIDATOR_CLASS;

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

                    $concrete_validator = self::NAMESPACE_TO_CONCRETE_VALIDATOR
                        . $tmp_class_name . self::SECOND_PART_NAME_CONCRETE_VALIDATOR_CLASS;
                }

                if (! $concrete_validator::validate(value: $query_param_value)) {
                    return false;
                }
            }
        }

        return true;
    }
}
