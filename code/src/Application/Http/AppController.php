<?php
declare(strict_types=1);


namespace Decole\Hw18\Application\Http;


use Decole\Hw18\Domain\Service\BaseProductListService;
use Decole\Hw18\Domain\Service\CompileService;
use Decole\Hw18\Domain\Service\InnerProductService;
use Decole\Hw18\Domain\Service\RecipeService;
use DI\Container;
use Klein\Request;
use Klein\Response;
use Klein\ServiceProvider;

class AppController extends AbstractController
{
    public function index(Request $request, Response $response, ServiceProvider $service, Container $container): void
    {
        try {
            $baseServiceService = $container->get(BaseProductListService::class);
            $innerProductService = $container->get(InnerProductService::class);
            $recipesService = $container->get(RecipeService::class);

            $service->render('views/index.phtml', [
                'baseProducts' => $baseServiceService->list(),
                'innerProducts' => $innerProductService->list(),
                'recipes' => $recipesService->list()
            ]);
        } catch (\Throwable $exception) {
            $this->error($response, [$exception->getMessage()]);
        }
    }

    public function create(Request $request, Response $response, ServiceProvider $service, Container $container): void
    {
        try {
            $serviceCompiler = $container->get(CompileService::class);
            [$resultDish, $cost] = $serviceCompiler->collect($request->params());

            $service->render('views/index.phtml', [
                'resultDish' => $resultDish,
                'cost' => $cost,
            ]);
        } catch (\Throwable $exception) {
            $this->error($response, [$exception->getMessage()]);
        }
    }
}