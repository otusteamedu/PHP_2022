<?php

namespace App\Services\Dtos;

class ReportCreateDto
{
    public mixed $params;

    public function __construct(mixed $params)
    {
        $this->params = $params;
    }
}
