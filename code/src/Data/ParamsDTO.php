<?php

namespace Ppro\Hw13\Data;

use Ppro\Hw13\Validators\Validator;

/** DTO для описания параметров, привязанных к событию
 *
 */
final class ParamsDTO
{
    private array $params = [];
    private string $paramsQuery;

    public function __construct(string $paramsQuery = '')
    {
        $this->paramsQuery = trim($paramsQuery);
        $this->getParamsFromString();
        Validator::validateParams($this->params);
    }

    private function getParamsFromString(): void
    {
        $this->params = explode(PHP_EOL, $this->paramsQuery);
        array_walk($this->params,fn(&$v) => $v = explode(' ',trim($v)));
    }

    public function getParams(): array
    {
        return $this->params;
    }
}