<?php

namespace Nka\Otus\Core;


use Nka\Otus\Core\Exceptions\CoreException;

abstract class AbstractController extends Component
{
    protected Config $config;
    public ?string $moduleName = null;

    public function __invoke()
    {
        return $this->run();
    }

    protected function render(string $view, $params = []) : View
    {
        return (new View(
            $this->config->layoutDir . ($this->layout ?? $this->config->baseLayout),
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
            return $this->config->projectDir . '/'
                .  $this->config->modulesDir . '/'
                . $this->moduleName . '/'
                . $this->config->viewsDir . '/';
        }
        return $this->config->projectDir . $this->config->viewsDir . '/';
    }

    abstract function run();
}