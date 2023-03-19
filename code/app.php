<?php
require_once __DIR__."/vendor/autoload.php";

use Ppro\Hw20\Application\App;

try {
    $app = new App();
    $app->run();
}
catch(\Exception $e){
    echo $e->getMessage();
}