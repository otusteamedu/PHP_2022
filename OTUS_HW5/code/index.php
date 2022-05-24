<?php

declare(strict_types=1);

require 'vendor/autoload.php';

$app=new \Shilyaev\Strings\App();
try{
    echo $app->run();
} catch(\Exception $exception)
{
    http_response_code(500);
    echo "Internal Server Error";
}