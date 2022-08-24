<?php

declare(strict_types=1);

namespace Nemizar\Php2022\Components;

use Nemizar\Php2022\Components\Exceptions\ViewNotFoundException;

class Render
{
    /**
     * @throws \Nemizar\Php2022\Components\Exceptions\ViewNotFoundException
     */
    public function render(string $viewPath, array $params): string|bool
    {
        \extract($params, \EXTR_OVERWRITE);

        \ob_start();

        if (\file_exists($viewPath)) {
            require $viewPath;
        } else {
            throw new ViewNotFoundException('Представление не найдено!');
        }

        return \ob_get_clean();
    }
}
