<?php

namespace Queen\App;

use Queen\App\Core\BaseMethods;

class Validator
{
    const ERROR = 'String is not valid';
    const SUCCESS = 'String is valid';

    /**
     * @param string $key
     *
     * @return string
     */
    public static function actionValidate(string $key)
    {
        if (BaseMethods::isPost() && $string = BaseMethods::getPost($key)) {
            if (!preg_match('~\((\)*\)*)\)~', $string)) {
                return self::ERROR;
            }

            $len = strlen($string);

            $brackets = [];
            for ($i = 0; $i < $len; $i++) {
                $symbol = $string[$i];
                if ($symbol == '(') {
                    $brackets[] = $symbol;
                } elseif ($symbol == ')') {
                    if (!$last = array_pop($brackets)) {
                        return self::ERROR;
                    }

                    if ($symbol === ')' && $last != '(') {
                        return self::ERROR;
                    }
                }
            }
            return count($brackets) === 0 ? self::SUCCESS : '';
        }
        return 'Result: ';
    }
}
