<?php

namespace nka\otus\modules\email_validator\controllers;

use nka\otus\core\View;
use nka\otus\modules\email_validator\base\AbstractModuleController;

class EmailGetController extends AbstractModuleController
{
    public function run(): View
    {
        return $this->render('main');
    }
}
