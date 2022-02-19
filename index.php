<?php

use KonstantinDmitrienko\PHPVersionsParser\PHPVersionsParser;

require 'vendor/autoload.php';

$parser = new PHPVersionsParser();

echo "Current stable PHP version is: " . $parser->getCurrentStableVersion();
