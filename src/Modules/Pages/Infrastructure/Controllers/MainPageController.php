<?php

declare(strict_types=1);

namespace Eliasjump\HwStoragePatterns\Modules\Pages\Infrastructure\Controllers;

use Eliasjump\HwStoragePatterns\App\BaseInfrastructure\BaseController;
use Eliasjump\HwStoragePatterns\App\Kernel\Response;

class MainPageController extends BaseController
{
    public function run(): string
    {
        $path = __DIR__ . "/../templates/main.php";

        return Response::render($path, []);
    }
}
