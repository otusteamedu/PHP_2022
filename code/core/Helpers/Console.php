<?php

namespace Core\Helpers;

class Console
{
    /**
     * @param string $msg
     * @param bool $date
     * @return void
     */
    public static function show(string $msg, bool $date = true) :void
    {
        echo $date ? date("Y-m-d H:i:s") . ': ' . $msg . PHP_EOL : $msg . PHP_EOL;
    }

    /**
     * @param string $msg
     * @param bool $date
     * @return string
     */
    public static function get(string $msg, bool $date = true) :string
    {
        return $date ? date("Y-m-d H:i:s") . ': ' . $msg . PHP_EOL : $msg . PHP_EOL;
    }

    /**
     * @return string
     */
    public static function readLine() :string
    {
        return trim(fgets(STDIN));
    }
}