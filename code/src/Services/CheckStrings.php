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

        if ($arrStr[0] == ')') {
            return false;
        }

        for ($i=0; $i<count($arrStr); $i++)
        {
            if ($i < count($arrStr) - 1) {
                if ($arrStr[$i] == ')' && $arrStr[$i + 1] == '(') {
                    return false;
                }
            }
        }

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