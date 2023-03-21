<?php

declare(strict_types=1);

echo cache() . validation();

/**
 * @return string
 */
function cache(): string
{
    $memcache = new Memcache();
    $memcache->addServer('memcached', 11211);
    $session = $memcache->get('client_session');

    if (!$session) {
        $memcache->set('client_session', 'Dankov-9');
        $session = 'Первое подключение. Следующее будет Dankov-9.';
    }

    session_start();
    $_SESSION['last_connect'] = time();

    if (!isset($_SESSION['first_visit'])) {
        $_SESSION['first_visit'] = time();
    }

    return 'Сервер: ' . $_SERVER['HOSTNAME']
        . '<br>Первый визит на сервер: ' . $_SESSION['first_visit']
        . '<br>Последний визит на сервер: ' . $_SESSION['last_connect']
        . '<br>Данные из memcache: ' . $session . '<br><br>';
}

/**
 * @return string
 */
function validation(): string
{
    $string = $_POST['string'] ?? '';

    if (!$string) {
        return response(400, 'Строка пустая.');
    }

    if (!is_string($string)) {
        return response(400, 'Строка не строка.');
    }

    if (!checkBracket($string)) {
        return response(400, 'Строка некорректна.');
    }

    return response();
}

/**
 * @param string $string
 * @return bool
 */
function checkBracket(string $string): bool
{
    if (substr_count($string, ')') !== substr_count($string, '(')) {
        return false;
    }

    if ($string[0] === ')') {
        return false;
    }

    $countLeftBracket = 0;
    $countRightBracket = 0;

    for ($i = 0; $i <= strlen($string) - 1; $i++) {
        if ($string[$i] === '(') {
            $countLeftBracket++;
        } else {
            $countRightBracket++;
        }

        if ($countRightBracket > $countLeftBracket) {
            return false;
        }
    }

    return true;
}

/**
 * @param int $code
 * @param string $message
 * @return string
 */
function response(int $code = 200, string $message = 'Строка корректна.'): string
{
    http_response_code($code);
    return $message;
}
