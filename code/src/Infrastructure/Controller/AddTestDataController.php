<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\Controller;

use Nikolai\Php\Application\Service\AddTestDataService;
use Symfony\Component\HttpFoundation\Request;

class AddTestDataController implements ControllerInterface
{
    public function __construct(private AddTestDataService $addTestDataService) {}

    public function __invoke(Request $request)
    {
        $this->addTestDataService->execute();
    }

}