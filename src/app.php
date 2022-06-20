<?php
declare(strict_types=1);

use Igor\Php2022\App;

require_once('vendor/autoload.php');

try
{
    $app = new App($argv[1]);
    $app->run();
}
catch(Exception $e)
{

}