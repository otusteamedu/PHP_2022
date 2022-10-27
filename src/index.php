<?php

$responseStatusCode = 200;
$responseMessage = "Проверка пройдена успешно";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $responseStatusCode = 400;
    $responseMessage = "Ошибка! К приложению можно обращаться только через HTTP-метод POST";
} elseif (empty($_POST["string"])) {
    $responseStatusCode = 400;
    $responseMessage = "Ошибка! Не передан параметр string";
} else {
    $counter = 0;
    foreach (\str_split($_POST["string"]) as $symbol) {
        if ($symbol === "(") {
            $counter++;
        } elseif ($symbol === ")") {
            $counter--;
        } else {
            $responseStatusCode = 400;
            $responseMessage = "Ошибка! Недопустимый символ в строке";
            break;
        }

        if ($counter < 0) {
            break;
        }
    }

    if ($responseStatusCode !== 400 && $counter !== 0) {
        $responseStatusCode = 400;
        $responseMessage = "Ошибка! Неверная вложеность скобок";
    }
}

\http_response_code($responseStatusCode);
echo $responseMessage;
