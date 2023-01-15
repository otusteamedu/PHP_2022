<?php
namespace Otus\Task11\App;

use Otus\Task11\Core\Container\Container;
use Otus\Task11\Core\View\ViewManager;

class Controller
{
    protected Container $container;

    public function __construct()
    {
        $this->container = Container::instance();
    }

    public function view(string $view, array $data = []): string
    {
        /** @var $viewManager ViewManager $view */
       $viewManager = $this->container->get('view');
       return $viewManager->make($data, $view)->render();
    }
}