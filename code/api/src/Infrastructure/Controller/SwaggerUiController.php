<?php

namespace App\Infrastructure\Controller;

use Nelmio\ApiDocBundle\Exception\RenderInvalidArgumentException;
use Nelmio\ApiDocBundle\Render\Html\AssetsMode;
use Nelmio\ApiDocBundle\Render\RenderOpenApi;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class SwaggerUiController
{
    /**
     * @var RenderOpenApi
     */
    private $renderOpenApi;

    public function __construct(RenderOpenApi $renderOpenApi)
    {
        $this->renderOpenApi = $renderOpenApi;
    }

    public function __invoke(Request $request, $area = 'default')
    {
        try {
            $response = new Response(
                $this->renderOpenApi->renderFromRequest($request, RenderOpenApi::HTML, $area, [
                    'assets_mode' => AssetsMode::CDN,
                ]),
                Response::HTTP_OK,
                ['Content-Type' => 'text/html']
            );

            return $response->setCharset('UTF-8');
        } catch (RenderInvalidArgumentException $e) {
            $advice = '';
            if (false !== strpos($area, '.json')) {
                $advice = ' Since the area provided contains `.json`, the issue is likely caused by route priorities. Try switching the Swagger UI / the json documentation routes order.';
            }

            throw new BadRequestHttpException(sprintf('Area "%s" is not supported as it isn\'t defined in config.%s', $area, $advice), $e);
        }
    }
}
