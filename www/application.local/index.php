<?php

declare(strict_types=1);

ini_set('session.save_handler', 'memcached');
ini_set('session.save_path', 'memcached:11211');
session_start();


$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
$string = !empty($post['string']) ? $post['string'] : ')(';
while (($position = strpos($string, '()')) !== false) {
	$string = substr($string, 0, $position) . substr($string, $position + 2);
}
if ($string === '') {
	header("HTTP/1.1 200");
	echo 'Всё хорошо - строка корректна ' . PHP_EOL;
} else {
	header("HTTP/1.1 400");
	echo 'Всё плохо - строка не корректна или пуста' . PHP_EOL;
}

echo '<br>PHP Контейнер ID: '.$_SERVER['HOSTNAME'].' <br>Session ID: '.session_id() . PHP_EOL;