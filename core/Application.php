<?php
declare(strict_types=1);

namespace Otus\Task12\Core;

use Otus\Task12\Core\Config\Config;
use Otus\Task12\Core\Container\Container;
use Otus\Task12\Core\Container\Contracts\ContainerContract;
use Otus\Task12\Core\Http\HttpRequest;
use Otus\Task12\Core\Http\Response;
use Otus\Task12\Core\Routing\RouterManager;
use Otus\Task12\Core\View\ViewManager;
use Otus\Task12\Core\ORM\Databases;

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
        $this->container->set('database', new Databases($this->container['config']['database']));

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