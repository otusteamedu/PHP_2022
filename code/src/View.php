<?php

namespace Anosovm\HW5;

class View
{
    public function __construct(private readonly string $view)
    {
    }

    public function show(array $data): string
    {
        extract($data);
        ob_start();
        require $this->view;
        return ob_get_clean();
    }
}