<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

session_start();

$service = new \Chernysh\Hw4\Service\CheckStringService();
$app = new \Chernysh\Hw4\App($service);
$app->run();


echo '<br>';
echo '<br>';
echo "Текущий контейнер: " . $_SERVER['HOSTNAME'];

echo '<br>';
echo '<br>';
echo "Номер сессии: " . session_id();


$_SESSION['random'] = $_SESSION['random'] ?? rand(1, 100);

echo '<br>';
echo '<br>';
echo "random number: " . $_SESSION['random'];