<?php

use App\Validator\ValidatorFactory;

require_once './vendor/autoload.php';

$fileManager = new App\FileManager\FileManager();

$inputName = trim($argv[1]);

$validator = ValidatorFactory::createByEmail();
$validator->validate($inputName);
