<?php

namespace Kogarkov\Es\Core\Http\Contract;

interface HttpResponseInterface
{
    public function setData(array $data): object;
    public function asJson(): object;
    public function isOk(): void;
    public function isBad(): void;
}
