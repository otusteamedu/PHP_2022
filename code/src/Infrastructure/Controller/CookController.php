<?php

declare(strict_types=1);

namespace Cookapp\Php\Infrastructure\Controller;

use Cookapp\Php\Application\Service\CookDishService;
use Cookapp\Php\Application\Service\RequestParserService;
use Symfony\Component\HttpFoundation\Request;

/**
 * Cook controller
 */
class CookController implements ControllerInterface
{
    /**
     * @param RequestParserService $requestParserService
     * @param CookDishService $cookDishService
     */
    public function __construct(
        private RequestParserService $requestParserService,
        private CookDishService $cookDishService
    ) {
    }

    /**
     * @param Request $request
     * @return mixed|void
     * @throws \Exception
     */
    public function __invoke(Request $request)
    {
        $argv = $request->server->get('argv');
        $dishDto = $this->requestParserService->createDishDto(array_splice($argv, 2));
        $this->cookDishService->cookDish($dishDto);
    }
}
