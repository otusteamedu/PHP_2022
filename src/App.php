<?php

declare(strict_types=1);

namespace Nemizar\Php2022;

use Nemizar\Php2022\Chat\ChatAppFactory;

class App
{
    public function run(): void
    {
        $chatApp = ChatAppFactory::getApp();
        $chatApp->start();
    }
}
