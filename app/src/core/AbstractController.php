<?php

namespace nka\otus\core;

use Psr\Container\ContainerInterface;

abstract class AbstractController extends Component
{
    public ?string $layout = null;
    public ?string $layoutDir = null;
    public ?string $viewsDir = null;
    public ?string $moduleName = null;
    public ?string $projectDir = null;


    public function __invoke()
    {
        return $this->run();
    }

    protected function render(string $view, $params = []) : View
    {

        return new View(
            $this->layoutDir . $this->layout,
            $this->getViewsDir() .  $view,
            $params
        );
    }

    protected function getViewsDir(): string
    {
        if (!is_null($this->moduleName)) {
            return $this->projectDir . 'modules/' . $this->moduleName . '/' . $this->viewsDir . '/';
        }
        return $this->projectDir . $this->viewsDir . '/';
    }

    abstract function run();
}