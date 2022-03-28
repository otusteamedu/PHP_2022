<?php

namespace nka\otus\core;

use nka\otus\core\exceptions\ApplicationException;

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
        $view = $this->getFileName($this->view);
        if (file_exists($view)) {
            ob_start();
            extract($this->variables);
            include $this->getFileName($this->view);
            $content = ob_get_contents();
            ob_end_clean();
            return $content;
        }
        throw new ApplicationException('Cannot find view file ' . $view);
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
