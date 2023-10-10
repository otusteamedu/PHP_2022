<?php

declare(strict_types=1);

namespace App\Application\App;

use App\Application\Command\CommandInterface;

interface ApplicationInterface
{
    public function run(): void;

    public function getCommand(): CommandInterface;
}
