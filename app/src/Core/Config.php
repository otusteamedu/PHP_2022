<?php

namespace Nka\Otus\Core;

class Config extends Component
{
    public string $basePath;
    public string $publicDir;
    public string $projectDir;
    public string $modulesDir;
    public string $viewsDir;
    public string $baseLayout;
    public string $layoutDir;

    public function __construct(array $config)
    {
        $this->loadParams($config);
        $this->setLayoutDir();
    }

    protected function setLayoutDir()
    {
        $this->layoutDir = $this->projectDir . $this->viewsDir . DIRECTORY_SEPARATOR;
    }
}