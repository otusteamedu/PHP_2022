<?php

namespace nka\otus\modules\email_validator\controllers;

use nka\otus\core\exceptions\ApplicationException;
use nka\otus\modules\email_validator\base\AbstractModuleController;
use nka\otus\modules\email_validator\components\CorrectEmailChecker;
use nka\otus\core\Request;

class EmailPostController extends AbstractModuleController
{
    public function __construct(
        public Request $request,
        public CorrectEmailChecker $checker,
    )
    {
    }

    public function run(): string
    {
        $string = $this->request->getValue('string');
        if (empty($string)) {
            throw new ApplicationException('Строка пустая', 400);
        }
        $checker = $this->checker;
        if (!$checker->check($string)) {
            throw new ApplicationException('Некорректный email', 400);
        }
        return 'Email корректный';
    }
}
