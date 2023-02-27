<?php

declare(strict_types=1);

namespace Eliasj\Hw16;

use Eliasj\Hw16\App\Kernel\Configs\RabbitConfig;
use Eliasj\Hw16\App\Kernel\Router;
use Eliasj\Hw16\Modules\Form\Infrastructure\Controllers\FormController;

class AppConsumer
{
    public Router $router;

    public function __construct()
    {
        RabbitConfig::getInstance()->load();
        $this->router = new Router();
    }

    public function run(): void
    {
        FormController::listen();
    }
}
