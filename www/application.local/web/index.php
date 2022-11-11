<?php

$str = $_POST['string'];

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Допустим только POST метод.', 405);
    }

    if (empty($str)) {
        throw new Exception('Пустой запрос', 400);
    }

    $remainder = removeBracketsCouples($str);
    if (!empty($remainder)) {
        throw new Exception('Неверный запрос. Заберите лишние скобки: '.$remainder, 400);
    }

    echo 'Скобки расставлены корректно.';

} catch (Exception $e) {
    http_response_code($e->getCode());
    echo $e->getMessage();
}


function removeBracketsCouples($str) {
    $coupleCount = substr_count($str, '()');
    if ($coupleCount > 0) {
        $str = str_replace('()', '', $str);
        return removeBracketsCouples($str);
    }
    return $str;
}
