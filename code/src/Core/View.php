<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw12\Core;

class View
{
    function generate(string $view, $data = null): void
    {
        if (!empty($data)) {
            $result = $data;
        }

        include ROOT . '/src/view/' . $view;
    }
}