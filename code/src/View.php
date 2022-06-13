<?php
declare(strict_types=1);

namespace Roman\Hw5;


class View
{
    private string $view;

    public function __construct($view='layouts/404.php')
    {
        $this->view = $view;
    }

    public function show(array $data=array()): string
    {
        extract($data);
        ob_start();
        require $this->view;
        $output = ob_get_clean();
        return $output;
    }
}