<?php

namespace Eliasjump\StringsVerification\Controllers;

use Eliasjump\StringsVerification\Request;

abstract class BaseController
{
    protected Request $request;

    public function __construct()
    {
        $this->request = Request::getInstance();
    }

    protected function response(int $code): string
    {
        try {
            http_response_code($code);
            return match ($code) {
                400 => '400 Bad Request',
                default => '200 OK',
            };
        } catch (\Exception $exception) {
            http_response_code(500);
            return '500 Server error';
        }
    }
}
