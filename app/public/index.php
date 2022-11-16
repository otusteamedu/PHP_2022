<?php

declare(strict_types=1);

use Eliasjump\EmailVerification\EmailValidator;

require __DIR__ . '/../vendor/autoload.php';

$emails = isset($_POST['emails']) ? explode("\n", $_POST['emails']) : [];
$response = [
    'emails' => $emails,
    'errors' => []
];

if (!empty($emails)) {
    $response['errors'] = (new EmailValidator($emails))->run();
}

ob_start();

require __DIR__ . '/../src/template.php';

echo ob_get_clean();