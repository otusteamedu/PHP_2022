<?php

declare(strict_types=1);

namespace Sveta\Code\Services;

use Sveta\Code\Http\Request;

final class CheckStrings
{
    public function check(Request $request): bool
    {
        $string = $request->getData()['string'];
        $arrStr = str_split($string);
        $oneBracket = 0;
        $twoBracket = 0;

        foreach ($arrStr as $str)
        {
            switch ($str) {
                case ')':
                    $oneBracket++;
                    break;
                case '(':
                    $twoBracket++;
                    break;
                default:
                    return false;
            }
        }

        return $oneBracket == $twoBracket;
    }
}