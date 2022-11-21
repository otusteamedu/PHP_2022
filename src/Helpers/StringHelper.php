<?php

namespace Dmitry\App\Helpers;

class StringHelper
{
    private static ?self $instance = null;

    private function __construct()
    {
    }

    /**
     * @return StringHelper
     */
    public static function getInstance(): StringHelper
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function validate(string $string): bool
    {
        if (empty($string)) {
            return false;
        }

        preg_match_all("/[()]/", $string, $braces);

        $braces = $braces[0];

        $count = 0;

        foreach ($braces as $brace) {
            if ($brace === '(') {
                $count++;
            } else {
                $count--;
            }

            if ($count < 0) {
                return false;
            }
        }

        return $count === 0;
    }
}