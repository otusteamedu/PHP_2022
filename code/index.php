<?php

use Roman\Hw4\App;
require_once 'vendor/autoload.php';

try{
    $app=new App;
    $app->run();
}catch (\Exception $error){

}
