<?php
declare(strict_types=1);

namespace Otus\Task11\Core;

use Otus\Task11\Core\Config\Config;
use Otus\Task11\Core\Container\Container;
use Otus\Task11\Core\Container\Contracts\ContainerContract;
use Otus\Task11\Core\Http\HttpRequest;
use Otus\Task11\Core\Http\Response;
use Otus\Task11\Core\Redis\RedisManager;
use Otus\Task11\Core\Routing\RouterManager;
use Otus\Task11\Core\View\ViewManager;

class Application
{
    private ?ContainerContract $container;

    public function __construct()
    {
        $this->container = Container::instance();

        $this->container->set('base_path', __DIR__ . '/../app');
        $this->container->setRequest(new HttpRequest($_POST));
        $this->container->set('config', new Config($this->container['base_path'] . '/config/app.php'));
        $this->container->set('view' , new ViewManager($this->container['config']['path_view']));
        $this->container->set('redis', new RedisManager($this->container['config']['redis']));
    }

    public function run(): void
    {
        $request = $this->container->getRequest();
        $router = new RouterManager();
        $fileRouter = $this->container['base_path'] . '/routers.php';
        if(file_exists($fileRouter)){
            require_once $fileRouter;
        }
        $response = $router->resolve($request)->run();
        if(!$response instanceof Response){
            $response = new Response((string)$response);
        }
        $response->send();
    }

}