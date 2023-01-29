<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw10;

use Nikcrazy37\Hw10\App\Search\SearchHandler;
use Nikcrazy37\Hw10\App\Input\InputHandler;
use Nikcrazy37\Hw10\App\View\ViewTable;
use Nikcrazy37\Hw10\Exception\AppException;

class App
{
    /**
     * @var SearchHandler
     */
    private SearchHandler $search;

    /**
     * @var array|bool
     */
    private array|bool $inputParam;

    /**
     * @var ViewTable
     */
    private ViewTable $view;

    public function __construct()
    {
        $this->search = new SearchHandler();
        $this->inputParam = InputHandler::getParam();
        $this->view = new ViewTable();
    }

    /**
     * @return void
     * @throws AppException
     */
    public function run(): void
    {
        $result = $this->search->run($this->inputParam);

        $headers = $this->search->getHeaders();

        $this->view->run($result, $headers);
    }
}