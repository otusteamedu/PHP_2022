<?php

namespace Ppro\Hw15\Commands;

use Ppro\Hw15\App;
use Ppro\Hw15\Views\ExitView;

class ExitCommand extends Command
{
    /**
     * @return void
     * @throws \Exception
     */
    public function execute(): void
    {
        $exitView = new ExitView();
        $exitView->render();
        if(!empty($exitView->exitConfirmed()))
            return;

        App::forward();
    }
}