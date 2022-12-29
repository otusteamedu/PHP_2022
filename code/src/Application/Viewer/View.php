<?php

namespace Otus\App\Application\Viewer;

class View
{
    static function render(string $view, array $data = []) {
        extract($data, EXTR_OVERWRITE);
        require_once('/data/mysite.local/src/Application/Views/'."$view.php");
        exit();
    }
}
