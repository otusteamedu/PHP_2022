<?php

declare(strict_types=1);

namespace HW10\App\Interfaces;

interface QueryInterface
{
    public function prepare(array $params): array;

    public static function prepareResponse(array $response, $DTO): array;

    public function getPreparedParams($options);

    public function getParams(): array;
}
