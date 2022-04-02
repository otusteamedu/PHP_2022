<?php

declare(strict_types=1);

namespace Ekaterina\Hw4\App;

use Ekaterina\Hw4\Controllers\MainController;
use Ekaterina\Hw4\Http\Response;
use Ekaterina\Hw4\View\View;
use Ekaterina\Hw4\Http\Request;
use Ekaterina\Hw4\ServerData\ServerData;
use Ekaterina\Hw4\Validator\BracketsValidator;
use Exception;

class App
{
    /**
     * @var View шаблон вывода
     */
    protected View $view;

    /**
     * @var Request|null Обертка над Request
     */
    protected ?Request $request = null;

    /**
     * @var MainController|null Контроллер
     */
    protected ?MainController $controller = null;

    /**
     * Constructor
     */
    public function __construct()
    {
        try {
            $this->controller = new MainController();
            //$this->request = new Request();
            //$this->view = new View();
            //if ($this->request->firstStart) {
            //    $this->view = new View('Вас приветствует валидатор скобочек');
            //} else {
            //    $this->view = new View();
            //}
        } catch (Exception $e) {
            MainController::error($e->getMessage());
        }
    }

    /**
     * Запуск приложения
     *
     * @return void
     */
    public function run(): void
    {
        if ($this->controller instanceof MainController) {
            $this->controller->page();
        }

        //if ($this->request->firstStart) {
        //    $this->view->page(new ServerData());
        //} elseif (!empty($this->request->fields)) {
        //    $brackets = new BracketsValidator($this->request->fields);
        //    Response::setResponseCode($brackets->validate());
        //    $this->view->result(new ServerData(), $brackets);
        //} else {
        //    Response::setResponseCode(false);
        //}
    }
}