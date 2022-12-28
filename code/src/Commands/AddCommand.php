<?php

namespace Ppro\Hw13\Commands;

use Ppro\Hw13\App;
use Ppro\Hw13\Repositories\Repository;
use Ppro\Hw13\Views\AddView;
use Ppro\Hw13\Views\ResultView;

/**
 *
 */
class AddCommand extends Command
{
    /**
     * @return void
     * @throws \Exception
     */
    public function execute(): void
    {
        $view = new AddView();
        $view->render();
        $event = $view->getEventData();

        $repo = new Repository();
        $repo->instance()->addEvent($event);

        $resultView = new ResultView();
        $resultView->render();

        App::forward();
    }
}