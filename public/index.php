<?php
declare(strict_types=1);

$post = [];
parse_str(file_get_contents('php://input'), $post);
$stringForValidation = $post['string'] ?? null;

try {
    if (!$stringForValidation) {
        throw new Exception('Тело запроса не должно быть пустым');
    }

    $stack = [];
    for ($i = 0; $i <= strlen($stringForValidation) - 1; $i++) {
        $symbol = $stringForValidation[$i];

        if (!in_array($symbol, ['(', ')'])) {
            throw new Exception('Недопустимый символ в теле запроса');
        }
        if ($symbol === '(') {
            $stack[] = $symbol;
        } else {
            array_pop($stack);
        }
    }
    count($stack) === 0 ? http_response_code(200) : throw new Exception('Тело запроса не прошло валидацию');


} catch (Exception $exception) {
    http_response_code(400);
}

