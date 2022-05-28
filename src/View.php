<?php


namespace Roman\Hw5;


class View
{
    private string $view;

    public function __construct($view)
    {
        $this->view=$view;
    }

    public function show(array $data): string
    {
        extract($data);
        ob_start();
        require $this->view;
        $output = ob_get_clean();
        return $output;
    }
}