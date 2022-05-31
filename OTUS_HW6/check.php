<?php

require 'vendor/autoload.php';

$App = new \Shilyaev\Mailchecker\App();

global $argv;

try {
    if (PHP_SAPI == 'cli')
    {
        $App->loadFromFile(isset($argv[1]) ? $argv[1] : NULL);
        echo $App->run(true);
        exit(0);
    }
    else
    {
        $App->loadFromRequest(isset($_REQUEST['emails']) ? $_REQUEST['emails'] : NULL);
        http_response_code(200);
        echo $App->run(false);
    }
}  catch(\Exception $exception) {
    if (PHP_SAPI == 'cli') {
        echo "Произошла ошибка: " . $exception->getMessage();
        exit(1);
    }
    else
    {
        http_response_code(400);
        echo "Произошла ошибка: " . $exception->getMessage();
    }
}
