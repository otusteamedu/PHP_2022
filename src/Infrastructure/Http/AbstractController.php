<?php

declare(strict_types=1);

namespace DKozlov\Otus\Infrastructure\Http;

use DKozlov\Otus\Application;

abstract class AbstractController
{
    private string $viewsPath;

    public function __construct()
    {
        $this->viewsPath = Application::config('views');
    }

    protected function view(string $view): string
    {
        $path = "{$this->viewsPath}/$view";

        if (!file_exists($path)) {
            return '';
        }

        ob_start();

        include $path;

        return ob_get_clean();
    }

    protected function json(array $data): string
    {
        return json_encode($data);
    }
}