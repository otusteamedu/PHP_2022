<?php

namespace Ppro\Hw13\Commands;

use Ppro\Hw13\App;
use Ppro\Hw13\Repositories\Repository;
use Ppro\Hw13\Views\FindView;
use Ppro\Hw13\Views\FindResultView;

class FindCommand extends Command
{
    /**
     * @return void
     * @throws \Exception
     */
    public function execute(): void
    {
        $view = new FindView();
        $view->render();
        $params = $view->getParamsData();

        $repo = new Repository();
        $result = $repo->instance()->findEvent($params);

        $findResultView = new FindResultView($result);
        $findResultView->render();

        App::forward();
    }
}