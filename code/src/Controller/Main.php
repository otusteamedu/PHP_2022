<?php

declare(strict_types=1);

namespace Ppro\Hw28\Controller;

use Ppro\Hw28\Controller\BaseController;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

/**
 *
 */
final class Main extends BaseController
{
    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $response->getBody()->write("MainPage");
        return $response;
    }
}
