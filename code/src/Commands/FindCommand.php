<?php

namespace Ppro\Hw15\Commands;

use Ppro\Hw15\App;
use Ppro\Hw15\Repositories\Repository;
use Ppro\Hw15\Views\FindView;
use Ppro\Hw15\Views\FindResultView;

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
        $id = $view->getParamsData();

        $repo = new Repository();
        $result = $repo->instance()->findSession((int)$id);

        $findResultView = new FindResultView($result);
        $findResultView->render();

        App::forward();
    }
}