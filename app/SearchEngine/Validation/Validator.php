<?php

declare(strict_types=1);

namespace App\SearchEngine\Validation;

use App\SearchEngine\Mechanisms\DTO\QueryParamsDTO;

final class Validator
{
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
            if (! empty($query_param_value)) {
                $param_name = ucfirst(string: $query_param_name);

                $concrete_validator = '\App\SearchEngine\Validation\Services\\' . $param_name . 'Validation';

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

                    $concrete_validator = '\App\SearchEngine\Validation\Services\\' . $tmp_class_name . 'Validation';
                }

                return $concrete_validator::validate(value: $query_param_value);
            }
        }

        return true;
    }
}
