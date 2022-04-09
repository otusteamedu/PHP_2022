<?php

declare(strict_types=1);

namespace Ekaterina\Hw4\App;

use Ekaterina\Hw4\Controllers\MainController;
use Exception;

class App
{
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
    }
}