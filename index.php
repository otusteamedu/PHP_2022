<?php

require_once './vendor/autoload.php';

$fileManager = new App\FileManager\FileManager();

$inputName = trim($argv[1]);
$outputName = trim($argv[2]);

if (!$inputName || !$outputName) {
    throw new \Exception('fill file name');
}

$input = $fileManager->open($inputName, 'r');
$output = $fileManager->createOrOpen($outputName, 'r+');

$validator = new App\Validator\EmailValidator();

$input->every(function ($value) use ($validator, $output) {
    $output->putLine($value . ' - ' . ($validator->validate($value) ? 'success' : 'false'));
});

$input->close();
$output->close();
