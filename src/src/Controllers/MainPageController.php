<?php

declare(strict_types=1);

namespace Eliasjump\HwRedis\Controllers;

use Eliasjump\HwRedis\Kernel\Response;

class MainPageController extends BaseController
{
    public function run(): string
    {
        $path = __DIR__ . "/../templates/main.php";

        return Response::render($path, []);
    }
}
