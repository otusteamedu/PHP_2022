<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw6;

use Nikcrazy37\Hw6\Exception\ClassNotFoundException;
use Nikcrazy37\Hw6\App\Config;
use Nikcrazy37\Hw6\Exception\EmptyAppNameException;
use Nikcrazy37\Hw6\Exception\IncorrectAppNameException;

class App
{
    protected string $appName;

    /**
     * @param $appName
     * @throws EmptyAppNameException
     * @throws IncorrectAppNameException
     * @throws ClassNotFoundException
     */
    public function __construct($appName)
    {
        if (empty($appName)) {
            throw new EmptyAppNameException();
        }

        if (!in_array($appName, Config::APP_NAME)) {
            throw new IncorrectAppNameException();
        }

        $this->appName = Config::APP_NAMESPACE . ucfirst($appName);

        if (!class_exists($this->appName)) {
            throw new ClassNotFoundException();
        }
    }

    /**
     * @return void
     */
    public function run()
    {
        $app = new $this->appName();
        $app->run();
    }
}