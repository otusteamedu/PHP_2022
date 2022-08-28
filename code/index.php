<?php

use Rs\Rs\App;

require 'vendor/autoload.php';

try{
     (new App())->run();
}catch (Exception $e){
    var_dump($e);
}
