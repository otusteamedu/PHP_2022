<?php
require __DIR__ . '/vendor/autoload.php';


session_start();

echo 'Идентификатор сессии: ' . session_id().'<br>';
echo "Текущий контейнер: " . $_SERVER['HOSTNAME'];
