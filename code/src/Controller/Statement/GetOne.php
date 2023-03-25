<?php

declare(strict_types=1);

namespace Ppro\Hw28\Controller\Statement;

use Slim\Psr7\Request;
use Slim\Psr7\Response;

/**
 *
 */
final class GetOne extends Base
{
    /**
     * @param array<string> $args
     */
    public function __invoke(
        $id,
        Response $response
    ): Response {
        $data = $this->getServiceFindStatement()->getOne((int) $id);
        return $this->jsonResponse($response, 'success', $data, 200);
    }
}
