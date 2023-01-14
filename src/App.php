<?php
declare(strict_types=1);

namespace Larisadebelova\Php2022;

use Larisadebelova\Php2022\Services\StringService;

class App
{

    private StringService $stringService;

    public function __construct(StringService $stringService)
    {
        $this->stringService = $stringService;
    }

    public function run()
    {
        $a = "fooo + barr";
        echo $this->stringService->getLength($a);
    }
}