<?php

declare(strict_types=1);

namespace Carab\Php2022;

use AlexanderTolmachev\MyFirstPackage\GreetingProcessor;

class App
{
    public function run()
    {
        $processor = new GreetingProcessor();
        echo $processor->getGreeting('Max');
    }
}