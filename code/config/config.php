<?php

return [
    'host' => getenv('ELASTIC_HOST'),
    'user' => getenv('ELASTIC_USER'),
    'password' => getenv('ELASTIC_PASS'),
    'cert' => getenv('ELASTIC_CERT_PATH'),
];