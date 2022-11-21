<?php

use Dmitry\App\Helpers\StringHelper;

require_once '../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stringHelper = StringHelper::getInstance();

    if ($stringHelper->validate($_POST['string'] ?? '')) {
        http_response_code(200);
        echo 'Все хорошо';
    } else {
        http_response_code(400);
        echo 'Все плохо';
    }
} else {
    session_start();

    if (isset($_SESSION['counter'])) {
        $_SESSION['counter']++;
    } else {
        $_SESSION['counter'] = 1;
    }

    echo 'ID сессии: ' . session_id() . '<br>';
    echo 'Счетчик посещений: ' . $_SESSION['counter'] . '<br>';
    echo 'Контейнер: ' . $_SERVER['HOSTNAME'];
}