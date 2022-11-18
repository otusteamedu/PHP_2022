<?php

try {
    if (!isset($_POST['string'])) {
        throw new ErrorException('Некорректный параметр');
    }

    //$param = '(()()()()))((((()()()))(()()()(((()))))))';
    $param = $_POST['string'];

    if (empty($param)) {
        throw new ErrorException('Некорректный параметр');
    }

    $split = mb_str_split($param);
    $temp = [];
    foreach ($split as $letter) {
        if ($letter != '(' && $letter != ')') {
            continue;
        }

        if (count($temp) == 0) {
            $temp[] = $letter;
        } elseif ($temp[count($temp) - 1] == '(' && $letter == ')') {
            unset($temp[count($temp) - 1]);
            $temp = array_values($temp);
        } else {
            $temp[] = $letter;
        }
    }

    if (count($temp)) {
        throw new ErrorException('Некорректный параметр');
    }

    header("HTTP/1.1 200 OK");
    echo 'Корректный параметр';
} catch (ErrorException $e) {
    header("HTTP/1.1 400 Bad Request");
    echo $e->getMessage();
}
