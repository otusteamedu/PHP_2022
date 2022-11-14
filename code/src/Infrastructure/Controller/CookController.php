<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\Controller;

use Nikolai\Php\Application\Service\CookDishService;
use Nikolai\Php\Application\Service\RequestParserService;
use Symfony\Component\HttpFoundation\Request;

class CookController implements ControllerInterface
{
    public function __construct(
        private RequestParserService $requestParserService,
        private CookDishService $cookDishService
    ) {}

    public function __invoke(Request $request)
    {
        $argv = $request->server->get('argv');
        $dishDto = $this->requestParserService->createDishDto(array_splice($argv, 2));
        $this->cookDishService->cookDish($dishDto);
    }
}