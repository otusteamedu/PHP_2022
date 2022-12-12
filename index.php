<?php

require __DIR__ . '/vendor/autoload.php';

for ($i = 0; $i < 4; $i++) {
    $emails[] = readline('Введите почту: ');
}

$app = new \Sveta\Php2022\App();
$result = $app->run($emails);
print_r($result);
