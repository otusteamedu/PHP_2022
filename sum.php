#!/usr/bin/env php
<?php
if (php_sapi_name() != 'cli' || $argc < 3) {
    die('Check run mode or arguments');
}
echo (float)$argv[1] + (float)$argv[2];