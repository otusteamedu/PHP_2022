<?php

namespace Nka\Otus\Core;


use Nka\Otus\Core\Exceptions\CoreException;

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
        return (new View(
            $this->layoutDir . $this->layout,
            $this->getViewsDir() .  $view,
            $params
        ));
    }

    protected function asJson(array $array): string
    {
        $encoded = json_encode($array, JSON_UNESCAPED_UNICODE);
        if (!$encoded) {
            throw new CoreException('Wrong Json');
        }
        return $encoded;
    }

    protected function getViewsDir(): string
    {
        if (!is_null($this->moduleName)) {
            return $this->projectDir . 'Modules/' . $this->moduleName . '/' . $this->viewsDir . '/';
        }
        return $this->projectDir . $this->viewsDir . '/';
    }

    abstract function run();
}