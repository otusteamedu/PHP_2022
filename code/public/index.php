<?php
declare(strict_types=1);

use Otus\App\App;
use Otus\App\Viewer\Result;

require_once __DIR__ . '/../vendor/autoload.php';

try {
    $app = new App();
    $app->run();
} catch(Exception $e){
    Result::failure($e->getMessage());
}
