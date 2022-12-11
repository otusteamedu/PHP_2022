<?php

require __DIR__ . '/vendor/autoload.php';

for ($i = 0; $i < 4; $i++) {
    $emails[] = readline('Введите почту: ');
}

$service = new \Sveta\Php2022\EmailChecker();
$app = new \Sveta\Php2022\App($service);
$result = $app->run($emails);
print_r($result);
