<?php

use Roman\Hw5\App;

require_once 'vendor/autoload.php';

try{
    $app=new App();
    $app->run();
}catch(\Exception $e){
    echo 'Error';
}
