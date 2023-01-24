<?php

namespace Otus\Mvc\Application\Viewer;

class View
{
    static function render(string $view, array $data = []) {
        extract($data, EXTR_OVERWRITE);
        require_once(__DIR__.'/../Views/'."$view.php");
        exit();
    }
}
