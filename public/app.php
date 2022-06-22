<?php
declare(strict_types=1);

use Igor\Php2022\App;

require dirname(__DIR__).'/vendor/autoload.php';

try
{
    $app = new App($argv[1]);
    $app->run();
}
catch(Exception $e)
{

}