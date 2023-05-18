<?php

declare(strict_types=1);

namespace Rehkzylbz\OtusHw4;

class RequestProvider {

    /**
     * 
     * @param string $parameter_name
     * @param string $default_value
     * @return string
     */
    public function get_post_parameter(string $parameter_name = '', string $default_value = ''): string {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        $parameter = !empty($post[$parameter_name]) ? $post[$parameter_name] : $default_value;
        return $parameter;
    }

}
