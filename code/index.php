<?php

try {    
    $request = $_POST['string'];

    if (empty($request)) {
        throw new Exception("Request string is empty");
    }
    
    $is_match = preg_match("/^[^()\n]*+(\((?>[^()\n]|(?1))*+\)[^()\n]*+)++$/", $request);

    if ($is_match) {
        print_r("Everything is OK");
    } else {
        throw new Exception("Request string is wrong");
    }
} catch (Exception $ex) {
    http_response_code(400);
    print_r($ex->getMessage());
}