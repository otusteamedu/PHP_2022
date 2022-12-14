<?php

namespace Otus\App\Viewer;

class View
{
    static function render(string $view, array $data = []) {
        extract($data, EXTR_OVERWRITE);
        require_once('/data/mysite.local/src/Views/'."$view.php");
        exit();
    }
}
