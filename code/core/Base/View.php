<?php

namespace Core\Base;

use Core\Exceptions\InvalidArgumentException;

class View
{
    /**
     * @var string
     */
    private string $view_path = APP_PATH . '/resources/view';

    /**
     * @param string $view
     * @param array $data
     * @return string|null
     * @throws InvalidArgumentException
     */
    public function make(string $view,array $data = [])
    {
        $path = $this->getFullPath($this->normalizeName($view));

        return $this->render($path, $data);
    }

    /**
     * @param string $path
     * @param array $data
     * @return false|string
     * @throws InvalidArgumentException
     */
    private function render(string $path, array $data = [])
    {
        if (!file_exists($path)) {
            throw new InvalidArgumentException("View file: {$path} is not exists.");
        }

        ob_start();
        extract($data, EXTR_SKIP);
        include($path);
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    /**
     * @param string $path
     * @return View
     */
    public function setViewPath(string $path) :View
    {
        $this->view_path = $path;

        return $this;
    }

    /**
     * Normalize the given view name.
     *
     * @param  string  $name
     * @return string
     */
    public function normalizeName(string $name) :string
    {
        return str_replace('.', '/', $name);
    }

    /**
     * @param string $path
     * @return string
     */
    public function getFullPath(string $path) :string
    {
        return $this->view_path . '/' . $path . '.php';
    }
}