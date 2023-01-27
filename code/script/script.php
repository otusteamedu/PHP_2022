<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

$client = new Otus\App\Application\Entity\Consumer\ClientRecipient();
$client->getMessage();
