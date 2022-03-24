<?php

use App\Validator\ValidatorFactory;

require_once './vendor/autoload.php';

$fileManager = new App\FileManager\FileManager();

$inputName = trim($argv[1]);

if (!$inputName) {
    throw new \Exception('fill file name');
}

$validator = ValidatorFactory::createByEmail();

$validator->validate($inputName);
