<?php

declare(strict_types=1);

use Study\Chat\App;

require '../vendor/autoload.php';

try {
    $app = new App();
    $app->run();
}
catch(Exception $e){
    echo $e->getMessage();
}