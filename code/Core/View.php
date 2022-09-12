<?php

namespace Otus\Mvc\Core;
use Otus\Mvc\Core\Assets;
use Otus\Mvc\Core\Assets\img;

class View
{
    static function render(string $view, array $data = []) {
        extract($data, EXTR_OVERWRITE);
        require_once implode(DIRECTORY_SEPARATOR, [$_SERVER['DOCUMENT_ROOT'], 'Views', "$view.php"]);
        exit();
    }
}
