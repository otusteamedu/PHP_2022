<?php
require __DIR__ . '/../vendor/autoload.php';

$config = require __DIR__ . '/../config/index.php';

echo (new ATolmachev\MyApp\App($config))->run();