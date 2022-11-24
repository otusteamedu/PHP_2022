<?php

const ERROR_DATA_MSG = 'Невалидное входящее значение';
const ERROR_CODE = 400;

function callError()
{
    throw new Exception(ERROR_DATA_MSG, ERROR_CODE);
}

if (isset($_POST['string'])) {

    $string = $_POST['string'];
    $symbols = str_split($string);

    if ((strlen($string) % 2 != 0) || (strlen($string) == 0)) {
        callError();
    }

    $k = 0;
    foreach ($symbols as $symbol) {
        if ($symbol === '(') {
            $k += 1;
        } elseif ($symbol === ')') {
            $k -= 1;
        }

        if ($k < 0) {
            callError();
        }
    }

    if ($k == 0) {
        echo "ok";
    } else {
        callError();
    }
}