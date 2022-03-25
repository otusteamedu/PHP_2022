<?php

use App\Validator\ValidatorFactory;

require_once './vendor/autoload.php';

$fileManager = new App\FileManager\FileManager();

$validator = ValidatorFactory::createByEmail();
$validator->validate('emails.txt');
