<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(400); exit;
}

function checkStringBrackets($string)
{
    $length = strlen($string);
    $stack  = [];

    for ($i = 0; $i < $length; $i++) {
        switch ($string[$i]) {
            case '(':
                $stack[] = 0; break;
            case ')':
                if (array_pop($stack) !== 0) {
                    return false;
                }
                break;
            default: break;
        }
    }

    return empty($stack);
}

$string = $_REQUEST['string'];

try {

    if (empty($string)) {
        throw new \Exception();
    }

    if (checkStringBrackets($string) === false) {
        throw new \Exception();
    }

} catch (\Exception $e) {
    http_response_code(400); exit;
}

