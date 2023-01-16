<?php

use Sveta\Code\App;

require_once(__DIR__.'/vendor/autoload.php');

try {
    $app = new App();
    $app->run($argv[1]);
}
catch(Exception $e){
}