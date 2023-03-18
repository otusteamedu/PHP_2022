<?php
declare(strict_types=1);

use Svatel\Code\Application;
use Svatel\Code\Helper\ConsoleHelp;

include __DIR__ . '/../vendor/autoload.php';

try {
    print_r(ConsoleHelp::commands());
    Application::create($argv);
} catch (Exception $e) {
    print_r('error');
}