<?php

namespace Assembler;

use Dto\InputParametersDto;
use ValueObject\Parameter;

class InputParametersDtoAssembler
{
    /**
     * @param string[] $parameters
     * @return InputParametersDto
     */
    public function assemble(array $parameters): InputParametersDto
    {
        $dto = new InputParametersDto();

        $priceLow = isset($parameters[Parameter::PRICE_LOW]) ? (int)$parameters[Parameter::PRICE_LOW] : 0;
        $priceHigh = isset($parameters[Parameter::PRICE_HIGH]) ? (int)$parameters[Parameter::PRICE_HIGH] : 0;
        $offset = isset($parameters[Parameter::OFFSET]) ? (int)$parameters[Parameter::OFFSET] : 0;
        $limit = isset($parameters[Parameter::LIMIT]) ? (int)$parameters[Parameter::LIMIT] : 0;

        $dto->setTitle($parameters[Parameter::TITLE] ?? '');
        $dto->setSku($parameters[Parameter::SKU] ?? '');
        $dto->setCategory($parameters[Parameter::CATEGORY] ?? '');
        $dto->setPriceLow( $priceLow);
        $dto->setPriceHigh($priceHigh);
        $dto->setOffset($offset);
        $dto->setLimit($limit);

        return $dto;
    }
}
