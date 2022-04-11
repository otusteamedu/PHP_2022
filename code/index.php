<?php

use KonstantinDmitrienko\App\App;
use KonstantinDmitrienko\App\Response;

require_once('vendor/autoload.php');

try {
    $app = new App();
    $app->run();
} catch(RuntimeException $e){
    Response::failure($e->getMessage());
}
