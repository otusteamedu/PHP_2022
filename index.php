<?php

require_once './src/EmailChecker.php';
require_once './src/App.php';

for ($i = 0; $i < 4; $i++) {
    $emails[] = readline('Введите почту: ');
}

$service = new EmailChecker();
$app = new App($service);
$result = $app->run($emails);
print_r($result);
