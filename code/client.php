<?php
declare(strict_types=1);

$file = "myserver.sock";
$user = '1123';

while (!$user) {
    echo "Введите имя пользователя или 'q' для выхода:  ";
    $user = trim(fgets(STDIN));
    if ($user === 'q') {
        echo "Выход выполнен." . PHP_EOL;
        exit();
    }
}
while (true) {
    echo "Напишите сообщение или 'q' для выхода:  ";
    $message = trim(fgets(STDIN));
    if ($message === 'q') {
        echo "Выход выполнен." . PHP_EOL;
        exit();
    }

    if ($message) {
        try {
            $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
            if ($socket === false) {
                echo "Не удалось создать сокет!" . PHP_EOL;
            }
            $connect = socket_connect($socket, $file);
            if ($connect === false) {
                echo "Не удалось подключиться к сокету!" . PHP_EOL;
            } else {
                socket_write($socket, "$user:	$message");
            }
        } catch (Exception $e) {
            echo "Произошла ошибка: " . $e->getMessage() . PHP_EOL;
        }
    } else {
        echo "Пустое сообщение - не сообщение ) " . PHP_EOL;
    }
}
