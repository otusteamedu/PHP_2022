<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw4\Model;

use \Exception;

class Stringer
{
    /**
     * @param $string
     * @return mixed
     * @throws Exception
     */
    public static function validate($string)
    {
        if (empty($string)) {
            throw new Exception('[ERROR] Empty string. Enter string value!', 400);
        }

        $count = 0;
        $symbols = str_split($string);

        foreach ($symbols as $parenthesis) {
            switch ($parenthesis) {
                case "(":
                    $count++;
                    break;
                case ")":
                    $count--;
                    break;
                default:
                    throw new Exception('[ERROR] Incorrect symbol. Enter only parenthesis!', 400);
            }

            if ($count < 0) {
                throw new Exception('[ERROR] Too many closing parenthesis. Checking failed!', 400);
            }
        }

        if ($count !== 0) {
            throw new Exception('[ERROR] Incorrect count opening and closing parentheses. Checking failed!', 400);
        }

        throw new Exception('[SUCCESS] Checking succeeds!', 200);
    }
}