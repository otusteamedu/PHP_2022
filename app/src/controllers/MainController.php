<?php

namespace hw4\controllers;

use hw4\components\CorrectBracketChecker;
use hw4\core\Controller;
use hw4\core\Exception;
use hw4\core\Request;

class MainController extends Controller
{
    public function __construct(
        public Request $request,
        public CorrectBracketChecker $checker,
    )
    {
    }

    public function actionPost(): string
    {
        $string = $this->request->getValue('string');
        if (empty($string)) {
            throw new Exception('Строка пустая', 400);
        }
        $checker = $this->checker;
        if (!$checker->check($string)) {
            throw new Exception('Некорректная строка', 400);
        }
        return 'Строка корректная';
    }

    public function actionGet()
    {
        return $this->render('main');
    }
}