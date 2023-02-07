<?php

include('../vendor/autoload.php');

use nka20\EasyS3\EasyS3Service;

$key = getenv('S3_STORAGE_KEY');
$secret = getenv('S3_STORAGE_SECRET');

$region = 'ru-central1';
$endpoint = 'https://storage.yandexcloud.net';

$s3 = new EasyS3Service(
    $key,
    $secret,
    $region,
    $endpoint
);

$bucket = 'upyachka-test-12345678910';
$text = 'Hello, easy s3';
$key = 'greetings.txt';

try {
    $s3->createBucket($bucket);
    $s3->putObject($bucket, $key, $text);

    echo $s3->getObject($bucket, $key) . PHP_EOL;

    $s3->deleteObject($bucket, $text);

} catch (\RuntimeException $e) {
    echo $e->getMessage() . PHP_EOL;
}