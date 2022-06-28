<?php

namespace App\Services\Dtos;

class ReportCreateDto
{
    public function __construct(private mixed $params)
    {
    }

    /**
     * @return mixed
     */
    public function getParams(): mixed
    {
        return $this->params;
    }
}
