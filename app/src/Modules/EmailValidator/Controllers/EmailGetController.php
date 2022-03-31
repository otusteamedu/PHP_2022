<?php

namespace Nka\Otus\Modules\EmailValidator\Controllers;

use Nka\Otus\Core\View;
use Nka\Otus\Modules\EmailValidator\Base\AbstractModuleController;

class EmailGetController extends AbstractModuleController
{
    public function run(): View
    {
        return $this->render('main');
    }
}
