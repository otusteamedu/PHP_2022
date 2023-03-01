<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw14\Libs;

abstract class AbstractView
{
    protected string $viewPath;

    /**
     * @param string $view
     * @param $data
     * @return void
     */
    public function generate(string $view, $data = null): void
    {
        if (!empty($data)) {
            $result = $data;
        }

        include ROOT . $this->viewPath . $view;
    }
}