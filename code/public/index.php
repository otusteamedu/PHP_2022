<?php
namespace App;

error_reporting(E_ALL);
ini_set('display_errors', '1');

if ( file_exists(dirname(__DIR__, 1).'/vendor/autoload.php') ) {
    require_once dirname(__DIR__, 1) .'/vendor/autoload.php';
}

$databaseService = new DatabaseService();
$databaseService->run();