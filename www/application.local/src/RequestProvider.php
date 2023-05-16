<?php

namespace Rehkzylbz\OtusHw4;

class RequestProvider {

    public function get_post_parameter(string $parameter_name = '', string $default_value = ''): string {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        $parameter = !empty($post[$parameter_name]) ? $post[$parameter_name] : $default_value;
        return $parameter;
    }

}
