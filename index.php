<?php

require __DIR__.'/vendor/autoload.php';

$service = new \Svatelnet\MyLibrary\ReverseService();
$tmp = new \Sveta\Php2022\App($service);
$tmp->run();