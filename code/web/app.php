<?php

require __DIR__ . '/../vendor/autoload.php';

use Waisee\SocketChat\AppFactory;

try {
    $app = AppFactory::create($argv[1]);
    $app->run();
}
catch(Exception $e){
    echo $e->getMessage();
}


