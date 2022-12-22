<?php

declare(strict_types=1);

namespace Eliasjump\HwStoragePatterns\Controllers;

use Eliasjump\HwStoragePatterns\Kernel\Response;

class MainPageController extends BaseController
{
    public function run(): string
    {
        $path = __DIR__ . "/../templates/main.php";

        return Response::render($path, []);
    }
}
