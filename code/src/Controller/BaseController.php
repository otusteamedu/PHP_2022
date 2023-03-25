<?php

namespace Ppro\Hw28\Controller;

use Psr\Container\ContainerInterface;
use Slim\Psr7\Response;


/**
 *
 */
abstract class BaseController
{
    /**
     * @param ContainerInterface $container
     */
    public function __construct(protected ContainerInterface $container)
    {
    }

    /**
     * @param Response $response
     * @param string $status
     * @param $data
     * @param int $code
     * @return Response
     */
    protected function jsonResponse(
      Response $response,
      string   $status,
               $data,
      int      $code
    ): Response
    {
        $result = [
          'code' => $code,
          'status' => $status,
          'data' => $data,
        ];

        $payload = json_encode($result);

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($code);
    }
}