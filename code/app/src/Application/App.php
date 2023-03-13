<?php

namespace Ppro\Hw27\App\Application;

use Ppro\Hw27\App\Controllers\AppController;
use Ppro\Hw27\App\Views\PageView;

class App
{
    /**
     * @var Registry|null
     */
    private ?Registry $reg;

    /**
     *
     */
    public function __construct()
    {
        $this->reg = Registry::instance();
    }

    /**
     * @return void
     */
    public function run()
    {
        $this->init();
        $this->handleRequest();
    }


    /**
     * @return void
     */
    private function init()
    {
        $this->reg->getApplicationHelper()->init();
    }


    /**
     * @return void
     * @throws \Exception
     */
    private function handleRequest()
    {
        $request = $this->reg->getRequest();
        $controller = new AppController();
        $cmd = $controller->getCommand($request);
        $cmd->execute($request);
        $viewTemplate = $controller->getView($request);
        (new PageView($viewTemplate))->render($request);
    }


}