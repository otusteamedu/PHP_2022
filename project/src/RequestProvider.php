<?php

declare(strict_types=1);

namespace Rehkzylbz\OtusHw7;

class RequestProvider {

    /**
     * 
     * @param int $position
     * @param string $default_value
     * @return string
     */
    public function get_argv(int $position = 0, string $default_value = ''): string {
        $argument = !empty($_SERVER['argv'][$position]) ? $_SERVER['argv'][$position] : $default_value;
        return $argument;
    }

}
