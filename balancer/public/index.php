<?php
session_start();
echo 'Сессия: ' . session_id() . '<br>';
echo 'Запрос обработал контейнер: ' . $_SERVER['HOSTNAME'];