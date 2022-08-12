<?php
require_once './vendor/autoload.php';
use Sbbs\PdoDb\Src\PdoDb;

$db_config = parse_ini_file('.env');
$db = PdoDb::getInstance($db_config);
var_dump($db);

