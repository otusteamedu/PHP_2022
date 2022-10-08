#!/usr/bin/env php
<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\SearchEngine\Engine;

$search_system = Engine::getInstance();
$search_system->start();
