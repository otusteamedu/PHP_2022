<?php

declare(strict_types=1);


namespace ATolmachev\MyApp\Controllers;


use ATolmachev\MyApp\Base\HttpException;
use ATolmachev\MyApp\Base\Controller;
use ATolmachev\MyApp\Models\ParenthesesChecker;

class ParenthesesCheckerController extends Controller
{
    /**
     * @throws HttpException
     */
    public function actionIndex(): string
    {
        if (!$this->components['request']->isPost()) {
            throw new HttpException(400, 'К приложению можно обращаться только через HTTP-метод POST');
        }

        if (!$string = $this->components['request']->post('string')) {
            throw new HttpException(400, 'Не передан параметр string');
        }

        $parenthesesChecker = new ParenthesesChecker();
        if (!$parenthesesChecker->check($string)) {
            throw new HttpException(400, $parenthesesChecker->getError());
        }

        return 'Проверка пройдена успешно';
    }
}