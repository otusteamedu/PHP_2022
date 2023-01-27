<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw10;

use Nikcrazy37\Hw10\App\Search\SearchHandler;
use Nikcrazy37\Hw10\App\Input\InputHandler;
use Nikcrazy37\Hw10\App\View\ViewTable;
use Nikcrazy37\Hw10\Exception\AppException;

class App
{
    private SearchHandler $search;
    private array $param;
    private ViewTable $view;

    public function __construct()
    {
        $this->search = new SearchHandler();
        $this->param = InputHandler::getParam();
        $this->view = new ViewTable();
    }

    /**
     * @return void
     * @throws AppException
     */
    public function run(): void
    {
        $result = $this->search->run($this->param);
        $this->view->run($result);
    }
}