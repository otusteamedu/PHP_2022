<?php
declare(strict_types=1);

namespace Roman\Hw5\Controllers;

use Roman\Hw5\View;

class NotFoundController
{
    private string $layout = 'layouts/404.php';

    public function run(): void
    {
        $view = new View($this->layout);
        echo $view->show();
    }

}