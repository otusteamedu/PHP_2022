<?php

namespace Otus\App\Application\Viewer;

/**
 * View controller
 */
class View
{
    /**
     * Render view
     * @param string $view
     * @param array $data
     * @return void
     */
    public static function render(string $view, array $data = [])
    {
        extract($data, EXTR_OVERWRITE);
        require_once('/data/mysite.local/src/Application/Views/' . "$view.php");
        exit();
    }
}
