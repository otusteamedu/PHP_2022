<?php

namespace App\Service;

use App\Models\Result;
use Pavelgaponenko\PgOtusComposerPackage\Service\JsonDecoder;

class ResultService
{
    public function __construct(
        private JsonDecoder $jsonDecoder,
    ) {
    }

    public function getResult(int $requestId): ?array
    {
        /** @var ?Result $result */
        $result = Result::where('request_id', '=', $requestId)->first();

        return $result !== null
            ? $this->jsonDecoder->toArray($result->data)
            : null;
    }
}
