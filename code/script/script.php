<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

$client = new Otus\Mvc\Application\Models\Entity\Consumer\ClientRecipient;
$client->getMessage();
