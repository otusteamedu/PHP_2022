<?php

namespace nka\otus\modules\brackets_validator\controllers;

use nka\otus\core\exceptions\ApplicationException;
use nka\otus\modules\brackets_validator\base\AbstractModuleController;
use nka\otus\modules\brackets_validator\components\CorrectBracketChecker;
use nka\otus\core\Request;

class BracketPostController extends AbstractModuleController
{
    public function __construct(
        public Request $request,
        public CorrectBracketChecker $checker,
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
            throw new ApplicationException('Некорректная строка', 400);
        }
        return 'Строка корректная';
    }
}
