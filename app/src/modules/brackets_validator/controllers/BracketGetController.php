<?php

namespace nka\otus\modules\brackets_validator\controllers;

use nka\otus\core\View;
use nka\otus\modules\brackets_validator\base\AbstractModuleController;

class BracketGetController extends AbstractModuleController
{
    public function run(): View
    {
        return $this->render('main');
    }
}
