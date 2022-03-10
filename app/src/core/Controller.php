<?php

namespace hw4\core;

class Controller
{
    public string $layout;
    public string $viewsDir;

    protected function render(string $view, $params = [])
    {
        return new View(
            $this->viewsDir . $this->layout,
            $this->viewsDir .  $view,
            $params
        );
    }
}