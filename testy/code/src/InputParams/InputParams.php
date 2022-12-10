<?php

declare(strict_types=1);

namespace Mapaxa\ElasticSearch\InputParams;

use Mapaxa\ElasticSearch\HandBook\InputParamsHandBook;

class InputParams
{
    /** @var array */
    private $params;

    public function __construct()
    {
        $this->params = getopt(InputParamsHandBook::SHORT_OPTIONS, InputParamsHandBook::LONG_OPTIONS);
    }


    public function getParams(): array
    {
        return $this->params;
    }

}