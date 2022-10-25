<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\Controller;

use Nikolai\Php\Application\Service\DropTablesService;
use Symfony\Component\HttpFoundation\Request;

class DropTablesController implements ControllerInterface
{
    public function __construct(private DropTablesService $dropTablesService) {}

    public function __invoke(Request $request)
    {
        $this->dropTablesService->execute();
    }
}