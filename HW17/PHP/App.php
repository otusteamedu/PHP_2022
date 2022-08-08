<?php

declare(strict_types = 1);

require 'vendor/autoload.php';

use App\Application;
use App\Domain;
use App\Infrastructure;

try {
    if (PHP_SAPI == 'cli')
    {
        $App = new Application\CheckEmailApp(new Infrastructure\Cli\UploadEmailContacts($argv[1] ?? NULL), new Infrastructure\Cli\Result());
    }
    else
    {
        $App = new Application\CheckEmailApp(new Infrastructure\Http\UploadEmailContacts(isset($_REQUEST['emails']) ? $_REQUEST['emails'] : NULL), new Infrastructure\Http\Result());
    }
    $App->checkEmails(new App\Application\Utils\CheckEmail());
    $App->printResult();
}  catch(Exception $exception) {
    echo "Произошла ошибка: " . $exception->getMessage();
}
catch(TypeError $exception) {
    echo "Произошла ошибка: " . $exception->getMessage();
}