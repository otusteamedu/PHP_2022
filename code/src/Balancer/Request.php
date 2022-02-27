<?php

declare(strict_types = 1);

namespace Masteritua\Src\Balancer;

class Request
{
    public function checkPost($value = 'POST'): bool
    {
        if ($_SERVER['REQUEST_METHOD'] !== $value) {
            return false;
        }

        return true;
    }

    public function getParam($value): string
    {
        return $_REQUEST[$value] ?? '';
    }
}