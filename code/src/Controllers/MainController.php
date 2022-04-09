<?php

declare(strict_types=1);

namespace Ekaterina\Hw4\Controllers;

use Ekaterina\Hw4\Http\Request;
use Ekaterina\Hw4\Http\Response;
use Ekaterina\Hw4\Router\SimpleRouter;
use Ekaterina\Hw4\ServerData\ServerData;
use Ekaterina\Hw4\Validator\BracketsValidator;
use Ekaterina\Hw4\View\View;

class MainController
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
     * @var string Действие, которое нужно сделать со страницей (по сути тип страницы)
     */
    protected string $action;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->action = (new SimpleRouter)->getAction();
        $this->view = new View();
        if ($this->action === SimpleRouter::ACTION_VALIDATE) {
            $this->request = new Request();
        }
    }

    /**
     * Инициирование вывода ошибки
     *
     * @param string $textError
     * @return void
     */
    public static function error(string $textError): void
    {
        $response = new Response(null, Response::CODE_ERROR);
        $response->send($textError);
    }

    /**
     * Работа со страницей в зависимости от ее типа
     *
     * @return void
     */
    public function page(): void
    {
        switch ($this->action) {
            case SimpleRouter::ACTION_INDEX:
                $this->view->page(new ServerData());
                break;
            case SimpleRouter::ACTION_VALIDATE:
                if (!empty($this->request->fields)) {
                    $brackets = new BracketsValidator($this->request->fields);
                    $brackets->validate();
                    $serverData = new ServerData();
                    $response = new Response($brackets->getResultValidate());
                    $response->send($brackets->getResultMessage(), $serverData->toArray());
                } else {
                    $response = new Response(null, Response::CODE_ERROR);
                    $serverData = new ServerData();
                    $response->send('Ошибка! Не удалось проверить скобочки', $serverData->toArray());
                }
                break;
            case SimpleRouter::ACTION_NOT_FOUND:
                Response::setHttpCode(Response::CODE_404);
                $this->view->notFound();
                break;
        }
    }
}