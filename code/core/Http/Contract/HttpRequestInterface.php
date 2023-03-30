<?php

namespace Core\Http\Contract;

interface HttpRequestInterface
{
    public function getGetParam(string $key);
    public function getRawPostBody();
    public function getRawPostParam(string $key);
    public function getRequestParam(string $key);
    public function getServerParam(string $key);
}
