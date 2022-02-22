<?php

declare(strict_types=1);

namespace Masteritua\Src\Balancer;

class BalancerHelper
{
    public function checkStringBrackets($string): bool
    {
        $length = strlen($string);
        $stack = [];

        for ($i = 0; $i < $length; $i++) {
            switch ($string[$i]) {
                case '(':
                    $stack[] = 0;
                    break;
                case ')':
                    if (array_pop($stack) !== 0) {
                        return false;
                    }
                    break;
                default:
                    break;
            }
        }

        return empty($stack);
    }
}
