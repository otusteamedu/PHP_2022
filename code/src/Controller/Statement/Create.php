<?php

declare(strict_types=1);

namespace Ppro\Hw28\Controller\Statement;

use Slim\Psr7\Request;
use Slim\Psr7\Response;

/**
 *
 */
final class Create extends Base
{
    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $input = (array) $request->getParsedBody();
        $data = $this->getServiceCreateStatement()->create($input);

        return $this->jsonResponse($response, 'success', $data,201);
    }
}
