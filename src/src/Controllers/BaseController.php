<?php

declare(strict_types=1);

namespace Eliasjump\HwRedis\Controllers;

use Eliasjump\HwRedis\Kernel\Request;

abstract class BaseController
{
    protected Request $request;

    public function __construct()
    {
        $this->request = Request::getInstance();
    }

    protected function response(int $code, array $res = []): string
    {
        try {
            http_response_code($code);
            return match ($code) {
                400 => '400 Bad Request',
                default =>  !$res ? '200 OK' : json_encode($res),
            };
        } catch (\Exception $exception) {
            http_response_code(500);
            return '500 Server error';
        }
    }
}
