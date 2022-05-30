<?php

require 'vendor/autoload.php';

$App = new \Shilyaev\Mailchecker\App();

try {
    echo $App->run();
}  catch(\Exception $exception) {
    exit("Произошла ошибка: ".$exception->getMessage());
}
