<?php
declare(strict_types=1);

namespace Otus\Task06\Core;


use Otus\Task06\Core\Config\Config;
use Otus\Task06\Core\Container\Container;
use Otus\Task06\Core\Http\Response;
use Otus\Task06\Core\View\ViewManager;

class Application extends Container
{

    public function __construct()
    {
        $this->registerContainers();
    }

    public function run($controller): Response
    {
        return $controller();
    }

    public function registerContainers(){

        $this->set('app_path', __DIR__ . '/..');

        $this->set('config', new Config($this['app_path'] . '/config/app.php'));
        $this->set('view' , new ViewManager($this['config']['path_view']));
    }
}