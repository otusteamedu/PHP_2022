<?php

namespace hw4\core;

class View
{
    protected string $content = '';

    public function __construct(
        public string $layout,
        public string $view,
        public array $variables,
    )
    {
    }

    protected function getContent()
    {
        ob_start();
        extract($this->variables);
        include $this->getFileName($this->view);
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    public function renderBody()
    {
        $content = $this->getContent();
        ob_start();
        include $this->getFileName($this->layout);
            $output = ob_get_contents();
            ob_end_clean();
        return $output;
    }

    public function getFileName(string $file): string
    {
        return $file . '.php';
    }



}