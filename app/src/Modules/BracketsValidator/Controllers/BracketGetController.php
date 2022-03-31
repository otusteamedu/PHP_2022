<?php

namespace Nka\Otus\Modules\BracketsValidator\Controllers;

use Nka\Otus\Core\View;
use Nka\Otus\Modules\BracketsValidator\Base\AbstractModuleController;

class BracketGetController extends AbstractModuleController
{
    public function run(): View
    {
        return $this->render('main');
    }
}
