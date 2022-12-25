<?php
declare(strict_types=1);

namespace Otus\Task06\Core;


use Otus\Task06\Core\Command\CommandProcessor;
use Otus\Task06\Core\Config\Config;
use Otus\Task06\Core\Container\Container;
use Otus\Task06\Core\Container\Contracts\ContainerContract;
use Otus\Task06\Core\Http\CliRequest;
use Otus\Task06\Core\Http\HttpRequest;
use Otus\Task06\Core\View\ViewManager;

class Application
{
    private ?ContainerContract $container;
    public function __construct()
    {
        $this->container = Container::instance();

        $this->container->set('app_path', __DIR__ . '/..');
        $this->container->setRequest(defined('STDIN') ? new CliRequest() :  new HttpRequest($_POST));
        $this->container->set('config', new Config($this->container['app_path'] . '/config/app.php'));
        $this->container->set('view' , new ViewManager($this->container['config']['path_view']));
    }

    public function run(): void
    {
        $request = $this->container->getRequest();
        $resolver = new CommandProcessor($this->container->get('config')->get('commands'));
        $command = $resolver->getCommand($request);
        $command->execute($request);
    }

}