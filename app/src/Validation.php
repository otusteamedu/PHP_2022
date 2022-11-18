<?php

declare(strict_types=1);

namespace Larisadebelova\App;

use Exception;

class Validation
{
    const SUCCESS = 'Всё хорошо';
    const ERROR = 'Всё плохо';

    /**
     * @param string $string
     * @return string
     * @throws Exception
     */
    public static function validate(string $string): string
    {
        $counter = 0;
        $firstClose = false;

        if (trim($string) == '') {
            throw new Exception(self::ERROR);
        }
        if (preg_match("/^\(.*\)/", $string)) {
            throw new Exception(self::ERROR);
        }

        $length = strlen($string);

        for ($i = 0; $i < $length; $i++) {
            $bracket = $string[$i];

            if ($bracket === '(') {
                $counter++;
            } elseif ($bracket === ')') {
                $counter--;
                if ($counter <= 0) {
                    $firstClose = true;
                }
            }
        }

        if ($counter !== 0 || $firstClose) {
            throw new Exception(self::ERROR, 400);
        }

        return self::SUCCESS;
    }
}