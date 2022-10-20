<?php

header('X-Container: ' . $_SERVER['HOSTNAME']);

$string = $_REQUEST['string'];

if (!$string || preg_match('/[^()]+/', $string) !== 0) {
    header('Status: 400 Bad Request');
    exit('всё плохо');
}

$opened = 0;
for ($i = 0; $i < strlen($string); $i++) {
    $opened = $string[$i] === '(' ? $opened + 1 : $opened - 1;
    if ($opened < 0) {
        break;
    }
}
if ($opened !== 0) {
    header('Status: 400 Bad Request');
    exit('всё плохо');
}
echo 'всё хорошо';