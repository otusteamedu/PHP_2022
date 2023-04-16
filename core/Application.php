<?php
declare(strict_types=1);

namespace Otus\Task14\Core;

use Otus\Task14\Core\Config\Contracts\ConfigInterface;
use Otus\Task14\Core\Http\Contract\HttpRequestInterface;
use Otus\Task14\Core\Http\ControllerResolve;
use Otus\Task14\Core\Http\Response;
use Otus\Task14\Core\Routing\RouteCollection;
use Otus\Task14\Core\Routing\RouterManager;
use Psr\Container\ContainerInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

class Application
{
    private ?ContainerInterface $container;

    public function __construct()
    {

        $this->container = new ContainerBuilder();
        $loader = new PhpFileLoader($this->container, new FileLocator(__DIR__ . '/..'));
        $loader->load('config/services.php');

        $this->container->compile();
    }


    public function run(): void
    {
        $config = $this->container->get(ConfigInterface::class);
        $request = $this->container->get(HttpRequestInterface::class);
        $router = new RouterManager(new RouteCollection());

        $fileRouter = $config->get('base_path') . '/config/routers.php';
        if (file_exists($fileRouter)) {
            require_once $fileRouter;
        }

        $controller = new ControllerResolve($router->resolve($request), $this->container);
        $response = $controller->make();
        if (!$response instanceof Response) {
            $response = new Response((string)$response);
        }
        $response->send();
    }

}