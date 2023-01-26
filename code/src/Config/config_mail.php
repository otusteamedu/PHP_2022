<?php

/**
 * Mailing config
 */

return [
    'mail' => [
        'hostname'   => $_ENV['MAILER_HOSTNAME'],
        'port'       => $_ENV['MAILER_PORT1'],
        'user'       => $_ENV['MAILER_USER'],
        'password'   => $_ENV['MAILER_PASSWORD'],
        'from_email' => $_ENV['MAILER_FROM_EMAIL']
    ]
];
