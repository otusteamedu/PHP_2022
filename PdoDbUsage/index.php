<?php

use Sbbs\PdoDb\Src\PdoDb;

require_once './vendor/autoload.php';

$db_config = parse_ini_file('.env');
$db = PdoDb::getInstance($db_config);
var_dump($db);

