<?php
require_once __DIR__."/vendor/autoload.php";

use Ppro\Hw27\Consumer\Application\App;

try {
    $app = new App();
    $app->run();
}
catch(\Exception $e){
    echo $e->getMessage();
}