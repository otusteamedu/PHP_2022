<?php

use Rs\Rs\App;

require 'vendor/autoload.php';

try{
     (new App())->run();
}catch (Exception $e){
    echo $e->getMessage();
}
