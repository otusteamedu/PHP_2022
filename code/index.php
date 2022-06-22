<?php

use Roman\Hw4\App;
require_once 'vendor/autoload.php';

try{
    $app=new App;
    echo $app->run();
}catch (\Exception $error){
    echo $error->getMessage();
    return;
}
