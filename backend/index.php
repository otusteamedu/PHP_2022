<?php

require __DIR__ . '/vendor/autoload.php';

use Ivan\Backend\ValidationService;
use Symfony\Component\HttpFoundation\Response;


session_start();

echo 'Идентификатор сессии: ' . session_id() . '<br>';
echo "Текущий контейнер: " . $_SERVER['HOSTNAME'] . '<br>';


$validationService = new ValidationService();
$validationService->run();
