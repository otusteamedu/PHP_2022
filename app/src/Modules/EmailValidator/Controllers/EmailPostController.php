<?php

namespace Nka\Otus\Modules\EmailValidator\Controllers;

use Nka\Otus\Components\Checker\CheckerException;
use Nka\Otus\Components\Checker\CheckerService;
use Nka\Otus\Core\Http\Request;
use Nka\Otus\Modules\EmailValidator\Base\AbstractModuleController;

class EmailPostController extends AbstractModuleController
{
    public function __construct(
        public Request $request,
        public CheckerService $checkerService,
    )
    {
    }

    /**
     * @throws CheckerException
     */
    public function run(): string
    {
        $string = $this->request->getValue('string');
        return $this->checkerService->check($string);
    }
}
