<?php

declare(strict_types=1);

namespace Larisadebelova\App;

use Exception;

class Validation
{
    const SUCCESS = 'Всё хорошо';
    const ERROR = 'Всё плохо';

    const LEFT_BRACE = '(';
    const RIGHT_BRACE = ')';

    /**
     * @param $string
     */
    public static function run($string)
    {
        try {
            self::validate($string);
            http_response_code(200);
            echo self::SUCCESS;
        } catch (Exception $e) {
            http_response_code(400);
            echo $e->getMessage();
        }
    }

    /**
     * @param string $string
     * @return void
     * @throws Exception
     */
    private static function validate(string $string): void
    {
        if (!self::validateBrace($string)) {
            throw new Exception(self::ERROR);
        }
    }

    /**
     * Проверка на
     * @param string $string
     * @return bool
     */
    private static function validateBrace(string $string): bool
    {
        $counter = 0;

        if ($string[0] === self::RIGHT_BRACE || empty($string)) {
            return false;
        }

        for ($ch = 0; $ch < strlen($string); $ch++) {
            if (self::LEFT_BRACE == $string[$ch]) {
                $counter++;
            } else {
                $counter--;
            }
        }

        return $counter == 0;
    }
}