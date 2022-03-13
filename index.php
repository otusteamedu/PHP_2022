<?php

require_once './vendor/autoload.php';

$fileManager = new App\FileManager\FileManager();

$input = $fileManager->open('emails.txt', 'r');
$output = $fileManager->createOrOpen('output.txt', 'r+');

$validator = new App\Validator\EmailValidator();

$input->every(function ($value) use ($validator, $output) {
    $output->putLine($value . ' - ' . ($validator->validate($value) ? 'success' : 'false'));
});

$input->close();
$output->close();
