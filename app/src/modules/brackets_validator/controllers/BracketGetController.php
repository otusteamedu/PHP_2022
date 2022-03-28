<?php

namespace hw4\modules\brackets_validator\controllers;

use hw4\core\View;
use hw4\modules\brackets_validator\base\AbstractModuleController;

class BracketGetController extends AbstractModuleController
{
    public function run()
    {
        return $this->render('main');
    }
}
