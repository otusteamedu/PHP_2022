<?php

session_start();

echo date('d.m.Y H:i:s') . '<br>';
echo 'Сервер:  '. $_SERVER['HOSTNAME'] . '<br>';
echo 'ID сессии: ' . session_id() . '<br>';
