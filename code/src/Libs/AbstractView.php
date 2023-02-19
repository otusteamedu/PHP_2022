<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw13\Libs;

abstract class AbstractView
{
    protected string $viewPath;

    function generate(string $view, $data = null): void
    {
        if (!empty($data)) {
            $result = $data;
        }

        include ROOT . $this->viewPath . $view;
    }
}