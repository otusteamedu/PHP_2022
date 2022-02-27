<?php

use Masteritua\Verification\Verification;

include "vendor/autoload.php";

$verification = new Verification();

try {
    echo $verification->check();
} catch (JsonException $e) {
    echo $e->getMessage();
}