<?php

declare(strict_types=1);

namespace Ekaterina\Hw4\App;

use Ekaterina\Hw4\Http\Response;
use Ekaterina\Hw4\View\View;
use Ekaterina\Hw4\Http\Request;
use Ekaterina\Hw4\ServerData\ServerData;
use Ekaterina\Hw4\Validator\BracketsValidator;

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
     * Constructor
     */
    public function __construct()
    {
        $this->request = new Request();
        if (empty($this->request->fields)) {
            $this->view = new View('Вас приветствует валидатор скобочек');
        } else {
            $this->view = new View();
        }
    }

    /**
     * Запуск приложения
     *
     * @return void
     */
    public function run(): void
    {
        if (empty($this->request->fields)) {
            $this->view->page(new ServerData());
        }
        
        if (!empty($this->request->fields)) {
            $brackets = new BracketsValidator($this->request->fields);
            Response::setCode($brackets->validate());
            $this->view->result(new ServerData(), $brackets);
        }
    }
}