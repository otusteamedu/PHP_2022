<?php

declare(strict_types=1);

namespace Mselyatin\Project6\src\controllers;

use Mselyatin\Project6\src\classes\Controller;
use Mselyatin\Project6\src\classes\JSONResponse;

/**
 * @IndexController
 * @\Mselyatin\Project6\src\controllers\IndexController
 */
class IndexController extends Controller
{
    /**
     * @throws \JsonException
     */
    public function index(): void
    {
        $response = new JSONResponse();
        $response->addItem('status', 'success');
        $response->addItem('message', 'Main page');

        echo $response->buildResponse();
    }
}