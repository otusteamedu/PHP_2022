<?php

namespace Ppro\Hw15\Commands;

use Ppro\Hw15\App;
use Ppro\Hw15\Repositories\Repository;
use Ppro\Hw15\Views\CheckView;
use Ppro\Hw15\Views\ResultView;

class CheckCommand extends Command
{
    /**
     * @return void
     * @throws \Exception
     */
    public function execute(): void
    {
        $view = new CheckView();
        $view->render();
        $status = trim($view->getParamsData()) === "on";

        $repo = new Repository();
        $result = $repo->instance()->checkIdentityMapInMovieEntity(2,$status);

        $ResultView = new ResultView($result['EQUALITY'],'Объекты идентичны' , 'Объекты разные');
        $ResultView->render();

        App::forward();
    }
}