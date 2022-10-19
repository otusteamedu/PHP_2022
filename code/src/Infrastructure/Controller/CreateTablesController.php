<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\Controller;

use Nikolai\Php\Application\Service\CreateTablesService;
use Symfony\Component\HttpFoundation\Request;

class CreateTablesController implements ControllerInterface
{
    public function __construct(private CreateTablesService $createTablesService) {}

    public function __invoke(Request $request)
    {
        $this->createTablesService->execute();
    }
}