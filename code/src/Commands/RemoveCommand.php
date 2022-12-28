<?php

namespace Ppro\Hw13\Commands;

use Ppro\Hw13\App;
use Ppro\Hw13\Repositories\Repository;
use Ppro\Hw13\Views\ConfirmView;
use Ppro\Hw13\Views\ResultView;

class RemoveCommand extends Command
{
    /**
     * @return void
     * @throws \Exception
     */
    public function execute(): void
    {
        $view = new ConfirmView();
        $view->render('Do you want to remove all events?');
        if($view->confirmed()){
            $repo = new Repository();
            $repo->instance()->removeEvents();

            $resultView = new ResultView();
            $resultView->render();
        }
        App::forward();
    }
}